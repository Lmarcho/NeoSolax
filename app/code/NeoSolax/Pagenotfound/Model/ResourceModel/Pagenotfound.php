<?php
namespace NeoSolax\Pagenotfound\Model\ResourceModel;

class Pagenotfound extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('neosolax_pagenotfound', 'pagenotfound_id');
    }
}
