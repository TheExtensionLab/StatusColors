<?php

/**
 * Extension Information System Config Block
 *
 * @category    TheExtensionLab
 * @package     TheExtensionLab_StatusColors
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_StatusColors_Block_Adminhtml_System_Config_ExtensionInfo
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     *  Sets this renderer to use a template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('theextensionlab/statuscolors/system/config/extension-info.phtml');
    }

    /**
     * Add renderView() to our render function so that a template is used.
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->renderView();
        return $html;
    }

    /**
     * Get current extension version to be displayed in the admin
     *
     * @return Mage_Core_Model_Config_Element
     */
    public function getExtensionVersion()
    {
        return Mage::getConfig()->getNode('modules/TheExtensionLab_StatusColors/version');
    }
}