<?php class TheExtensionLab_StatusColors_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getStatusColumn()
    {
        $column = array(
            'header' => Mage::helper('sales')->__('Status 2'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options'   => Mage::getSingleton('sales/order_config')->getStatuses(),
//            'renderer'  => 'theextensionlab_statuscolors/adminhtml_sales_grid_renderer_status'
            'frame_callback' => array($this, 'decorateStatus')
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
            'frame_callback' => array($this, 'decorateStatus')
        );

        return $column;
    }

    /**
     * Decorate status column values
     *
     * @return string
     */
    public function decorateStatus($value, $row, $column, $isExport)
    {
        $status = $row->getStatus();

        $item = Mage::getModel('sales/order_status')->load($status);
        if($item->getColor()) {
            $customColor = $item->getColor();
            $statusHtml = '<span class="custom-color" style="background-color:'.$customColor.';"><span>'.$value.'</span></span>';

            return $statusHtml;
        }

        return;
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