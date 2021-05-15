<?php

namespace NeoSolax\Slider\Model\ResourceModel\SliderImage;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('NeoSolax\Slider\Model\SliderImage', 'NeoSolax\Slider\Model\ResourceModel\SliderImage');
    }
}
