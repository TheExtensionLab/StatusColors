<?php class TheExtensionLab_StatusColors_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_statusCollection = null;

    /**
     * @return array
     */
    public function getStatusColumn()
    {
        $column = array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options'   => Mage::getSingleton('sales/order_config')->getStatuses(),
            'frame_callback' => array($this, 'decorateStatus')
        );

        return $column;
    }

    /**
     * @return array
     */
    public function getStatusColorColumn()
    {
        $column = array(
            'header' => Mage::helper('sales')->__('Status Color'),
            'type'  => 'text',
            'index' => 'color',
            'width'     => '200px',
            'frame_callback' => array($this, 'decorateStatusUsingRowData')
        );

        return $column;
    }

    /**
     * Decorate status column values - but don't load collection as we don't need to.
     * @return string
     */
    public function decorateStatusUsingRowData($value)
    {
        $statusHtml = '<span class="custom-color" style="background-color:'.$value.';"><span>'.$value.'</span></span>';
        return $statusHtml;
    }

    /**
     * Decorate status column values
     *
     * @return string
     */
    public function decorateStatus($value, $row)
    {
        $rowStatus = $row->getStatus();

        $statusCollection = $this->_getStatusCollection();
        foreach($statusCollection as $status){
            if($status->getStatus() == $rowStatus){
                $customColor = $status->getColor();
            }
        }

        $statusHtml = '<span class="custom-color" style="background-color:'.$customColor.';"><span>'.$value.'</span></span>';

        return $statusHtml;
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

    /**
     * @return Mage_Sales_Model_Resource_Order_Status_Collection|null
     */
    protected function _getStatusCollection()
    {
        if($this->_statusCollection === null){
            $this->_statusCollection = Mage::getModel('sales/order_status')->getCollection();
        }
        return $this->_statusCollection;
    }
}