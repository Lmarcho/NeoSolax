<?php
namespace NeoSolax\AdminReview\Model\ResourceModel;

class ReviewVideo extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('neosolax_promotional_product_review', 'id');
    }
}
