<?php 

/**
 * StatusColors Observer Model
 *
 * @category    TheExtensionLab
 * @package     TheExtensionLab_
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_StatusColors_Model_Observer
{
    protected $_currentOrderGridBlockClass = 'Mage_Adminhtml_Block_Sales_Order_Grid';

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        $this->_catchRewrittenOrderGridThatDoesntExtentOriginalClass();

        if ($block instanceof $this->_currentOrderGridBlockClass) {

            //Get the status column and add a frame_callback which adds the colour to the html
            $column = $block->getColumn('status');
            $column->setFrameCallback(array($this->getHelper(), 'decorateStatus'));
            return $this;
        }

        //Adds a new feild to the new/edit status forms
        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_Status_Edit_Form || $block instanceof Mage_Adminhtml_Block_Sales_Order_Status_New_Form) {
            $form = $block->getForm();
            $elements = $form->getElements();
            foreach ($elements as $element) {
                switch($element->getId()){
                    case "base_fieldset":
                        //Add a color field to the fieldset
                        $element->addField('color', 'text',
                            array(
                                'name'      => 'color',
                                'label'     => Mage::helper('sales')->__('Status Color'),
                                'class'     => 'color {hash:true,adjust:false}'
                            )
                        );

                        //Once we have added a new field we need to set the form values again to populate this feild
                        $model = Mage::registry('current_status');
                        if ($model) {
                            $form->addValues($model->getData());
                        }

                        break;
                }
            }
        }

        return $this;
    }

    protected function _catchRewrittenOrderGridThatDoesntExtentOriginalClass(){
        $rewriteNode = (string) Mage::getConfig()->getNode('global/blocks/adminhtml/rewrite/sales_order_grid');

        if($rewriteNode){
            $this->_currentOrderGridBlockClass = $rewriteNode;
        }

        return $this->_currentOrderGridBlockClass;
    }

    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        switch($block->getNameInLayout()) {
            case "order_info":
                $transport = $observer->getEvent()->getTransport();
                $html = $transport->getHtml();
                $customColor = Mage::helper('theextensionlab_statuscolors')->getStatusColor($block->getOrder()->getStatus());
                $html = preg_replace(
                    '/id="order_status"/',
                    '$0  class="custom-color" style="background-color:'.$customColor.';"',
                    $html
                );

                $transport->setHtml($html);
                break;
        }

        return $this;
    }

    public function getHelper()
    {
        return Mage::helper('theextensionlab_statuscolors');
    }

}
