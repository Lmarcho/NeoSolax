<?php

namespace NeoSolax\AdminReview\Model\Form\Attributes;

use Magento\Framework\DataObject;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreRepository;
use NeoSolax\AdminReview\Model\Review;

class Options extends DataObject implements ArrayInterface
{
    protected $_storeRepository;
    protected $_storeManager;

    public function __construct(
        StoreRepository $storeRepository,
        StoreManagerInterface $storemanager,
        Review $review
    )
    {
        $this->review = $review;
        $this->_storeManager = $storemanager;
        $this->_storeRepository = $storeRepository;
    }

    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $result;
    }

    public function getOptions()
    {
        return [
            'image' => __('image'),
            'video' => __('video'),
        ];
    }
}
