<?php

namespace NeoSolax\Slider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PwaSlider extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('neosolax_slider_slider','id');
	}

}
