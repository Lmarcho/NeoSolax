<?php

namespace NeoSolax\Slider\Model;

use Magento\Framework\Model\AbstractModel;

class SliderImage extends AbstractModel
{
    public function _construct()
    {
        $this->_init('NeoSolax\Slider\Model\ResourceModel\SliderImage');
    }
}
