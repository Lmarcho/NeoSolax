<?php
namespace NeoSolax\AdminReview\Model\ResourceModel\Review;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('NeoSolax\AdminReview\Model\Review', 'NeoSolax\AdminReview\Model\ResourceModel\Review');
    }

}


