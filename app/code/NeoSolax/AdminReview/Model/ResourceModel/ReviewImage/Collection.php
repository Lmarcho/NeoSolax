<?php
namespace NeoSolax\AdminReview\Model\ResourceModel\ReviewImage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('NeoSolax\AdminReview\Model\ReviewImage', 'NeoSolax\AdminReview\Model\ResourceModel\ReviewImage');
    }

}


