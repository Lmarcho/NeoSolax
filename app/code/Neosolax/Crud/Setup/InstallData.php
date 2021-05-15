<?php
namespace Neosolax\Crud\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $data = [
            ['firstName' => 'Lakshitha','lastName' => 'Mathngadeera','dob' => '11/14/1995','startDate' => '10/26/2020','contact' => '0719690981']

        ];
        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('neosolax_employee'), $bind);
        }
    }
}
