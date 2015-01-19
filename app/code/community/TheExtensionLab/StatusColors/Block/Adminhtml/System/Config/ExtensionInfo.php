<?php class TheExtensionLab_StatusColors_Block_Adminhtml_System_Config_ExtensionInfo
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('theextensionlab/statuscolors/system/config/extension-info.phtml');
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $html = $this->renderView();
        return $html;
    }

    public function getExtensionVersion()
    {
        return Mage::getConfig()->getNode('modules/TheExtensionLab_StatusColors/version');
    }
}