<?php
namespace NeoSolax\Pagenotfound\Model;

class Pagenotfound extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'neosolax_pagenotfound';

    protected function _construct()
    {
        $this->_init('NeoSolax\Pagenotfound\Model\ResourceModel\Pagenotfound');
    }

}
