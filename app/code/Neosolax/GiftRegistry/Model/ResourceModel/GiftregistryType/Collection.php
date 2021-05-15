<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryType;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Neosolax\GiftRegistry\Model\GiftregistryType', 'Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryType');
    }
}
