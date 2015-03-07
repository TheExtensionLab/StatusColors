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
        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_Status_Edit_Form) {
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
                    '${1} class="custom-color" style="background-color:'.$customColor.';"',
                    $html
                );

                $transport->setHtml($html);
                break;
        }

        return $this;
    }

    /**
     * This section stops the 404 page when extension is newly installed and the admin session doesn't
     * have permission to view the system section. (We refresh the ACL before load if the section was
     * previously now allowed)
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPredispatchAdminhtmlSystemConfigEdit(Varien_Event_Observer $observer)
    {
        $section = $observer->getEvent()->getControllerAction()->getRequest()->getParam('section');

        switch($section){
            case "theextensionlab_statuscolors":
                if (!$this->_isSectionAllowed($section)) {
                    //Credit to @schmengler for making our idea easy to implement
                    //https://github.com/schmengler/AclReload
                    $session = Mage::getSingleton('admin/session');
                    $session->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
                }
                break;
        }

        return $this;
    }

    /**
     * Checks if the admin user has permissions to view the page
     *
     * @param $section
     * @return bool
     */
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

    /**
     * @return TheExtensionLab_StatusColors_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('theextensionlab_statuscolors');
    }

}