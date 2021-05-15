<?php
namespace Neosolax\GiftRegistry\Model;
use Magento\Framework\Model\AbstractModel;


class GiftregistryItems extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\GiftregistryItems::class);
    }
}
