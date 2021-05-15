<?php

namespace NeoSolax\SLider\Model\Home\Slider;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreRepository;
use NeoSolax\Slider\Model\PwaSliderFactory;

class SelectSlider extends DataObject implements ArrayInterface
{
    protected $_storeRepository;
    protected $_storeManager;

    public function __construct(
        RequestInterface $request,
        StoreRepository $storeRepository,
        StoreManagerInterface $storemanager,
        PwaSliderFactory $pwaSliderFactory
    ) {
        $this->_request = $request;
        $this->pwaSliderFactory = $pwaSliderFactory;
        $this->_storeManager = $storemanager;
        $this->_storeRepository = $storeRepository;
    }

    public function toOptionArray()
    {
        $itemId = $this->_request->getParam('id');
        $sliderColl = $this->pwaSliderFactory->create()->getCollection();
//        $usage = $sliderColl->addFieldToSelect('use_homeslider')->getData();
        $usageArray = [];
        foreach ($sliderColl as $item) {
            $usageArray[] = $item['use_homeslider'];
        }

        foreach ($sliderColl as $item) {
            if (($item->getId() == $itemId && $item->getUseHomeslider() == 'homeslider') || !in_array('homeslider', $usageArray)) {
                return [
                    ['value' => 'homeslider',
                        'label' => __('Home Slider')
                    ],
                    [
                        'value' => 'normalslider',
                        'label' => __('Normal Slider')
                    ]
                ];
            } else {
                return [
                    [
                        'value' => 'normalslider',
                        'label' => __('Normal Slider')
                    ]
                ];
            }
        }
        if ($sliderColl->getSize() == 0) {
            return [
                ['value' => 'homeslider',
                    'label' => __('Home Slider')
                ],
                [
                    'value' => 'normalslider',
                    'label' => __('Normal Slider')
                ]
            ];
        }
    }
}
