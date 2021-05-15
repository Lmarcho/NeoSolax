<?php

namespace NeoSolax\AdminReview\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('neosolax_promotional_product_review'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true],
                'ID'
            )
            ->addColumn(
                'enable',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                1,
                ['nullable' => true],
                'Enable'
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => true],
                'Product ID'
            )
            ->addColumn(
                'video_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Video URL'
            )
            ->addColumn(
                'video_upload',
                \Magento\Framework\DB\Ddl\Table::TYPE_BLOB,
                null,
                ['nullable' => true],
                'Video Upload'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Title'
            )
            ->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Description'
            );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('neosolax_promotional_product_review_image'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true],
                'ID'
            )
            ->addColumn(
                'image_sequence_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => true],
                'Image Sequence ID'
            )
            ->addColumn(
                'device_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true ,
                    ],
                'Device Type'
            )
            ->addColumn(
                'image_upload',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Image Upload'
            );

        $installer->getConnection()->createTable($table);
    }
}
