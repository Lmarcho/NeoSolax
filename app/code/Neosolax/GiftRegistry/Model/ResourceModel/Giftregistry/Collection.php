<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel\Giftregistry;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Neosolax\GiftRegistry\Model\Giftregistry', 'Neosolax\GiftRegistry\Model\ResourceModel\Giftregistry');
    }
}
