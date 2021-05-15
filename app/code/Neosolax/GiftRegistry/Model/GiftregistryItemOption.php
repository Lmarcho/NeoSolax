<?php

namespace Neosolax\GiftRegistry\Model;
use Magento\Framework\Model\AbstractModel;


class GiftregistryItemOption extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\GiftregistryItemOption::class);
    }
}
