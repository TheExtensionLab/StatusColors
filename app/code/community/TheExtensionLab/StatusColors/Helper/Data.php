<?php

/**
 * StatusColors Data Helper
 *
 * @category    TheExtensionLab
 * @package     TheExtensionLab_StatusColors
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */
class TheExtensionLab_StatusColors_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_statusCollection = null;

    public function getStatusColorColumn()
    {
        $column = array(
            'header'         => Mage::helper('sales')->__('Status Color'),
            'type'           => 'text',
            'index'          => 'color',
            'width'          => '200px',
            'frame_callback' => array($this, 'decorateStatusUsingRowData')
        );

        return $column;
    }

    public function decorateStatusUsingRowData($value)
    {
        $statusHtml = '<span class="custom-color" style="background-color:' . $value . ';">
                            <span>' . $value . '</span>
                       </span>';
        return $statusHtml;
    }

    public function decorateStatus($value, $row)
    {
        $rowStatus = $row->getStatus();
        $statusCollection = $this->_getStatusCollection();
        $customColor = null;

        foreach ($statusCollection as $status) {
            if ($status->getStatus() == $rowStatus) {
                $customColor = $this->getColorOrDefault($status->getColor());
            }
        }

        $statusHtml = $this->_wrapInBackgroundColorSpan($value, $customColor);

        return $statusHtml;
    }

    private function _wrapInBackgroundColorSpan($value, $backgroundColor)
    {
        if (!$backgroundColor) {
            return $value;
        }

        $html = '<span class="custom-color" style="background-color:' . $backgroundColor . ';">
                            <span>' . $value . '</span>
                       </span>';
        return $html;
    }

    public function getStatusColor($code)
    {
        $status = Mage::getModel('sales/order_status')
            ->load($code);
        return $this->getColorOrDefault($status->getColor());
    }

    public function getColorOrDefault($color)
    {
        if (empty($color)) {
            return Mage::getStoreConfig('admin/order_grid/default_status_color');
        }
        return $color;
    }

    protected function _getStatusCollection()
    {
        if ($this->_statusCollection === null) {
            $this->_statusCollection = Mage::getModel('sales/order_status')->getCollection();
        }

        return $this->_statusCollection;
    }

}