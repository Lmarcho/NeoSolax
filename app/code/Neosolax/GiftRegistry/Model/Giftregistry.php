<?php

namespace Neosolax\GiftRegistry\Model;

use Magento\Framework\Model\AbstractModel;

class Giftregistry extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(ResourceModel\Giftregistry::class);
    }


}
