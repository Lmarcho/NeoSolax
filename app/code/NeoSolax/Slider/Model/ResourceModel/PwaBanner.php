<?php

namespace NeoSolax\Slider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PwaBanner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('neosolax_slider_banner', 'id');
    }
}
