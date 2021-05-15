<?php

namespace Neosolax\GiftRegistry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GiftregistryItemOption extends AbstractDb
{

    public function _construct()
    {
        $this->_init('giftregistry_item_option', 'option_id');
    }
}
