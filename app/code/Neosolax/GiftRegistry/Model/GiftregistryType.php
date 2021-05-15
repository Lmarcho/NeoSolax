<?php

namespace Neosolax\GiftRegistry\Model;
use Magento\Framework\Model\AbstractModel;


class GiftregistryType extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\GiftregistryType::class);
    }
}
