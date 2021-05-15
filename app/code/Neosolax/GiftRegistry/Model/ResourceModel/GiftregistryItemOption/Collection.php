<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryItemOption;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Neosolax\GiftRegistry\Model\GiftregistryItemOption', 'Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryItemOption');
    }
}
