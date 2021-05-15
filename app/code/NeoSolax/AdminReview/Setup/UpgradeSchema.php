<?php
namespace NeoSolax\AdminReview\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.1.0', '<')) {
            $installer->getConnection()->dropColumn($installer->getTable('neosolax_promotional_product_review'), 'video_upload');
//            $installer->changeColumn(
//                $installer->getTable('neosolax_promotional_product_review'),
//                'video_url',
//                'video_upload',
//                [
//                    \Magento\Framework\DB\Ddl\Table::TYPE_BLOB,
//                    null,
//                    ['nullable' => true],
//                    'Video Upload'
//                ]
//            );

        }
        $installer->endSetup();
    }
}
