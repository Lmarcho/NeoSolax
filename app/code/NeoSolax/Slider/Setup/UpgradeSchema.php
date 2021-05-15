<?php

namespace NeoSolax\Slider\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $bannerTable = 'neosolax_slider_banner';
        if (version_compare($context->getVersion(), "2.0.0", "<")) {
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($bannerTable),
                    'time_schedule_in',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                        'length' => 255,
                        'comment' => 'Time Schedule In'
                    ]
                );
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($bannerTable),
                    'time_schedule_out',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                        'length' => 255,
                        'comment' => 'Time Schedule Out'
                    ]
                );
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($bannerTable),
                    'order_number',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'length' => 10,
                        'comment' => 'Sorting Order'
                    ]
                );
        }
        $setup->endSetup();
    }
}
