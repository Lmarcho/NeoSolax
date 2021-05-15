<?php
namespace NeoSolax\WhatThreeWords\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private EavSetupFactory $eavSetupFactory;

    /**
     * @var Config
     */
    private Config $eavConfig;

    /**
     * @var AttributeSetFactory
     */
    private AttributeSetFactory $attributeSetFactory;

    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig            = $eavConfig;
        $this->attributeSetFactory  = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $this->addWhatThreeWordsFieldToAddress($setup);
        }
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $this->updateWhatThreeWordsAttribute($setup);
        }
        $setup->endSetup();
    }

    /**
     * put your comment there...
     *
     * @param mixed $setup
     */
    protected function addWhatThreeWordsFieldToAddress($setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute('customer_address', 'what_three_words', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Unit Number',
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'system'=> false,
            'group'=> 'General',
            'sort_order' => 71,
            'global' => true,
            'visible_on_front' => true,
        ]);

        $customAttribute = $this->eavConfig->getAttribute('customer_address', 'what_three_words');

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address','customer_address_edit','customer_register_address']
        );
        $customAttribute->save();

        $installer = $setup;

        $installer->getConnection()->addColumn(
            $installer->getTable('quote_address'),
            'what_three_words',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'What3Words Address'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_address'),
            'what_three_words',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'What3Words Address'
            ]
        );
    }

    public function updateWhatThreeWordsAttribute($setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->updateAttribute('customer_address', 'what_three_words', 'sort_order', '71');
    }
}
