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
                                'class'     => 'color {hash:true,adjust:false}'
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

    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        switch($block->getNameInLayout()) {
            case "order_info":
                $transport = $observer->getEvent()->getTransport();
                $html = $transport->getHtml();
                $customColor = Mage::helper('theextensionlab_statuscolors')->getStatusColor($block->getOrder()->getStatus());
                $html = preg_replace('/id="order_status"/', 'id="order_status" class="custom-color" style="background-color:'.$customColor.';"', $html);

                $transport->setHtml($html);
                break;
        }
    }

    public function controllerActionPredispatchAdminhtmlSystemConfigEdit(Varien_Event_Observer $observer)
    {
        $section = $observer->getEvent()->getControllerAction()->getRequest()->getParam('section');

        switch($section){
            case "theextensionlab_statuscolors":
                if(!$this->_isSectionAllowed($section)) {
                    //Credit to @schmengler for making our idea easy to implement
                    //https://github.com/schmengler/AclReload
                    $session = Mage::getSingleton('admin/session');
                    $session->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
                }
                break;
        }
    }


    protected function _isSectionAllowed($section)
    {
        try {
            $session = Mage::getSingleton('admin/session');
            $resourceLookup = "admin/system/config/{$section}";
            if ($session->getData('acl') instanceof Mage_Admin_Model_Acl) {
                $resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
                if (!$session->isAllowed($resourceId)) {
                    throw new Exception('');
                }
                return true;
            }
        }
        catch (Zend_Acl_Exception $e) {
            return false;
        }
        catch (Exception $e) {
            return false;
        }
    }
}