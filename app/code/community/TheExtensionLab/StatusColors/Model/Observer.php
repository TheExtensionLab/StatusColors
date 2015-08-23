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

    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        $this->_catchRewrittenOrderGridThatDoesntExtendOriginalClass();

        if ($this->_isBlockOrderGrid($block)) {
            $this->_addDecorateStatusFrameCallback($block->getColumn('status'));
            return $this;
        }

        if ($this->_isStatusFormBlock($block)) {
            $form = $block->getForm();
            $elements = $form->getElements();
            foreach ($elements as $element) {
                if ($this->_isBasedFieldset($element)) {
                    $this->_addColorInputFeild($element);
                    $this->_populateFormWithNewFeild($form);
                }
            }
        }

        return $this;
    }

    private function _addDecorateStatusFrameCallback($column)
    {
        $column->setFrameCallback(array($this->getHelper(), 'decorateStatus'));
    }

    private function _isBlockOrderGrid(Mage_Core_Block_Abstract $block)
    {
        return $block instanceof $this->_currentOrderGridBlockClass;
    }

    private function _isStatusFormBlock(Mage_Core_Block_Abstract $block)
    {
        return $block instanceof Mage_Adminhtml_Block_Sales_Order_Status_Edit_Form
        || $block instanceof Mage_Adminhtml_Block_Sales_Order_Status_New_Form;
    }

    private function _addColorInputFeild($fieldset)
    {
        $fieldset->addField(
            'color', 'text',
            array(
                'name' => 'color',
                'label' => Mage::helper('sales')->__('Status Color'),
                'class' => 'color {hash:true,adjust:false}'
            )
        );
    }

    private function _populateFormWithNewFeild($form)
    {
        $model = Mage::registry('current_status');
        if ($model) {
            $form->addValues($model->getData());
        }
    }

    protected function _catchRewrittenOrderGridThatDoesntExtendOriginalClass()
    {
        $rewriteNode = (string)Mage::getConfig()->getNode('global/blocks/adminhtml/rewrite/sales_order_grid');

        if ($rewriteNode) {
            $this->_currentOrderGridBlockClass = $rewriteNode;
        }

        return $this->_currentOrderGridBlockClass;
    }

    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        switch ($block->getNameInLayout()) {
            case "order_info":
                $transport = $observer->getEvent()->getTransport();
                $html = $transport->getHtml();
                $customColor = Mage::helper('theextensionlab_statuscolors')->getStatusColor(
                    $block->getOrder()->getStatus()
                );
                $html = preg_replace(
                    '/id="order_status"/',
                    '$0  class="custom-color" style="background-color:' . $customColor . ';"',
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
