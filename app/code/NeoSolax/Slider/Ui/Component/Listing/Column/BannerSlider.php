<?php

namespace NeoSolax\Slider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use NeoSolax\Slider\Model\PwaSlider;

class BannerSlider extends Column
{
    protected $userFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        PwaSlider $pwaSlider,
        array $components = [],
        array $data = []
    )
    {
        $this->pwaSlider = $pwaSlider;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item[$fieldName] != '') {
                    $sliderTitle = $this->getSlider($item[$fieldName]);
                    $item[$fieldName] = $sliderTitle;
                }
            }
        }
        return $dataSource;
    }

    private function getSlider($sliderId)
    {
        $slider = $this->pwaSlider->load($sliderId);
        $title = $slider->getTitle();
        return $title;
    }
}
