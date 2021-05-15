<?php
namespace NeoSolax\Pagenotfound\Model\ResourceModel\Pagenotfound;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('NeoSolax\Pagenotfound\Model\Pagenotfound', 'NeoSolax\Pagenotfound\Model\ResourceModel\Pagenotfound');
    }
}
