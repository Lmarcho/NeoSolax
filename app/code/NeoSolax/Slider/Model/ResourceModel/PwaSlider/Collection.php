<?php

namespace NeoSolax\Slider\Model\ResourceModel\PwaSlider;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('NeoSolax\Slider\Model\PwaSlider', 'NeoSolax\Slider\Model\ResourceModel\PwaSlider');
    }
}
