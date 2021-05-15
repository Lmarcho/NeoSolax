<?php

namespace NeoSolax\Slider\Model;

use Magento\Framework\Model\AbstractModel;

class PwaBanner extends AbstractModel
{
    public function _construct()
    {
        $this->_init('NeoSolax\Slider\Model\ResourceModel\PwaBanner');
    }

}
