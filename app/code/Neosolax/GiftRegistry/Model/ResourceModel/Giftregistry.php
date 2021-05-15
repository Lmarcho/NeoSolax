<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Giftregistry extends AbstractDb
{

    public function _construct()
    {
        $this->_init('giftregistry', 'giftregistry_id');
    }
}
