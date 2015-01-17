<?php

/** @var $installer TheExtensionLab_StatusColors_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('sales/order_status'),
        'color',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'nullable' => true,
            'default' => null,
            'comment' => 'Color'
        )
    );

$installer->endSetup();