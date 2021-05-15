<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GiftregistryItems extends AbstractDb
{
    public function _construct()
    {
        $this->_init('giftregistry_items', 'item_id');
    }
}
