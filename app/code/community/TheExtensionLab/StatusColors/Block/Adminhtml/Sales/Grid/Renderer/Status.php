<?php
class TheExtensionLab_StatusColors_Block_Adminhtml_Sales_Grid_Renderer_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Prepare link to display in grid
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $status = $row->getStatus();
        $customColor = '#fff9db';

        $item = Mage::getModel('sales/order_status')->load($status);
        if($item->getColor()) {
            $customColor = $item->getColor();
        }

        $statusHtml = '<span class="custom-color" style="border-radius:4px;padding:2px 6px;background-color:'.$customColor.';">'.$status.'</span>';
        return $statusHtml;
    }

}
