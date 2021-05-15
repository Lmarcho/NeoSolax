<?php

namespace NeoSolax\SLider\Model\Home\Slider;

use Magento\Framework\DataObject;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreRepository;
use NeoSolax\Slider\Model\PwaSlider;

class Options extends DataObject implements ArrayInterface
{
    protected $_storeRepository;
    protected $_storeManager;

    public function __construct(
        StoreRepository $storeRepository,
        StoreManagerInterface $storemanager,
        PwaSlider $pwaSlider
    )
    {
        $this->pwaSlider = $pwaSlider;
        $this->_storeManager = $storemanager;
        $this->_storeRepository = $storeRepository;
    }

    public function toOptionArray()
    {
        $slider = $this->pwaSlider->getCollection()->getItems();

        $array = [];

        foreach ($slider as $item) {
            $array[] = ['value' => $item->getId(),
                'label' => __($item->getTitle())
            ];
        }
        return $array;
    }
}
