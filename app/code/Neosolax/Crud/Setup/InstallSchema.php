<?php
namespace Neosolax\Crud\Setup;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $table = $setup->getConnection()
            ->newTable($setup->getTable('neosolax_employee'))
            ->addColumn(
                'employee_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Employee ID'
            )
            ->addColumn(
                'firstName',
                Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'First Name'
            )
            ->addColumn(
                'lastName',
                Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'Last Name'
            )
            ->addColumn(
                'dob',
                Table::TYPE_DATE,
                null,
                ['nullable' => false],
                'Date of Birthday'
            )
            ->addColumn(
                'startDate',
                Table::TYPE_DATE,
                255,
                ['nullable' => false],
                'Starting Date'
            )
            ->addColumn(
                'contact',
                Table::TYPE_TEXT,
                12,
                ['nullable' => false],
                'Telephone Number'
            )

            ->setComment("Employee Details table");
        $setup->getConnection()->createTable($table);
    }
}
