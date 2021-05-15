<?php
namespace Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryItems;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init('Neosolax\GiftRegistry\Model\GiftregistryItems', 'Neosolax\GiftRegistry\Model\ResourceModel\GiftregistryItems');
    }
}
