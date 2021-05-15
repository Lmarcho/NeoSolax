<?php

namespace NeoSolax\Slider\Model\ResourceModel;

class SliderImage extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('neosolax_slider_image','id');
    }

}
