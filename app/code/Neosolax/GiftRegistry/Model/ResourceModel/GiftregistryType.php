<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GiftregistryType extends AbstractDb
{

    public function _construct()
    {
        $this->_init('giftregistry_type', 'type_id');
    }
}
