<?php class TheExtensionLab_StatusColors_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getStatusColumn()
    {
        $column = array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options'   => Mage::getSingleton('sales/order_config')->getStatuses(),
            'renderer'  => 'theextensionlab_statuscolors/adminhtml_sales_grid_renderer_status'
        );

        return $column;
    }
}