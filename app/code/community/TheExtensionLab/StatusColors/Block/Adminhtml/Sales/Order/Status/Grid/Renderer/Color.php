<?php
class TheExtensionLab_StatusColors_Block_Adminhtml_Sales_Order_Status_Grid_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Prepare link to display in grid
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $color = $row->getColor();

        if(!$color) {
            return $color;
        }

        $statusHtml = '<span class="custom-color" style="background-color:'.$color.';">'.$color.'</span>';
        return $statusHtml;
    }

}
