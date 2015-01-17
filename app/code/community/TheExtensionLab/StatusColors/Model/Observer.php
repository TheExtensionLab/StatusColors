<?php class TheExtensionLab_StatusColors_Model_Observer
{
    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        if($block instanceof Mage_Adminhtml_Block_Sales_Order_Grid){
            $block->removeColumn('status');
            return $this;
        }

        if($block instanceof Mage_Adminhtml_Block_Sales_Order_Status_Edit_Form){
            $form = $block->getForm();
            $elements = $form->getElements();
            foreach($elements as $element){
                switch($element->getId()){
                    case "base_fieldset":


                        $element->addField('color', 'text',
                            array(
                                'name'      => 'color',
                                'label'     => Mage::helper('sales')->__('Status Color'),
                            )
                        );

                        $model = Mage::registry('current_status');
                        if ($model) {
                            $form->addValues($model->getData());
                        }
                        break;
                }
            }
        }
    }
}