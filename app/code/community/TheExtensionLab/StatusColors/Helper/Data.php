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

    public function getStatusColorColumn()
    {
        $column = array(
            'header' => Mage::helper('sales')->__('Status Color'),
            'type'  => 'text',
            'index' => 'color',
            'width'     => '200px',
            'renderer'  => 'theextensionlab_statuscolors/adminhtml_sales_order_status_grid_renderer_color'
        );

        return $column;
    }

    /**
     * Retrieve status color
     *
     * @param   string $code
     * @return  string
     */
    public function getStatusColor($code)
    {
        $status = Mage::getModel('sales/order_status')
            ->load($code);
        return $status->getColor();
    }
}