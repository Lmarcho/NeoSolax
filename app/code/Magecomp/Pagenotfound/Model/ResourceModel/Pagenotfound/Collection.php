<?php
namespace Magecomp\Pagenotfound\Model\ResourceModel\Pagenotfound;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magecomp\Pagenotfound\Model\Pagenotfound', 'Magecomp\Pagenotfound\Model\ResourceModel\Pagenotfound');
    }
}
