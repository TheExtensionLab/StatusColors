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
    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_Grid) {

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

    /**
     * This function adds the span (color) around the status using preg_replace
     * could have used a template but that would mean if the template was edited
     * we would need manually update it, using preg_replace there isn't a need for that.
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
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

    /**
     * @return TheExtensionLab_StatusColors_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('theextensionlab_statuscolors');
    }

}
