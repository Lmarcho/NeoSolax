<?php

namespace NeoSolax\Slider\Model\ResourceModel\PwaBanner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('NeoSolax\Slider\Model\PwaBanner', 'NeoSolax\Slider\Model\ResourceModel\PwaBanner');
    }
}
