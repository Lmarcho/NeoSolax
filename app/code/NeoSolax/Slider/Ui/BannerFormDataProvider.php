<?php

namespace NeoSolax\Slider\Ui;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use NeoSolax\Slider\Model\ResourceModel\PwaBanner\CollectionFactory;
use NeoSolax\Slider\Model\SliderImageFactory;

class BannerFormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $addFieldStrategies;
    protected $addFilterStrategies;
    public $_objectManager;
    protected $_request;

    public function __construct(
        $name,
        StoreManagerInterface $storeManager,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        SliderImageFactory $sliderImageFactory,
        ObjectManagerInterface $objectManager,
        RequestInterface $request,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->_objectManager = $objectManager;
        $this->_request = $request;
        $this->storeManager = $storeManager;
        $this->sliderImageFactory = $sliderImageFactory;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $itemId = $this->_request->getParam('id');

        if (!empty($itemId)) {
            $items = $this->collection->getItems();
            $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $itemId);
            foreach ($items as $item) {
                $brandData = $item->getData();
                $this->loadedData[$item->getId()] = ['banner_fieldset' => $brandData];
                foreach ($bannerImage as $image) {
                    if ($image->getDesktopImageUrl()) {
                        $brandData['desktop_image'][0]['name'] = $image->getDesktopImageName();
                        $brandData['desktop_image'][0]['type'] = 'image';
                        $brandData['desktop_image'][0]['size'] = $image->getDesktopImageSize();
                        $brandData['desktop_image'][0]['url'] = $this->getMediaUrl() . $image->getDesktopImageUrl();
                    }
                    if ($image->getMobileImageUrl()) {
                        $brandData['mobile_image'][0]['name'] = $image->getMobileImageName();
                        $brandData['mobile_image'][0]['type'] = 'image';
                        $brandData['mobile_image'][0]['size'] = $image->getMobileImageSize();
                        $brandData['mobile_image'][0]['url'] = $this->getMediaUrl() . $image->getMobileImageUrl();
                    }
                    if ($image->getTabImageUrl()) {
                        $brandData['tab_image'][0]['name'] = $image->getTabImageName();
                        $brandData['tab_image'][0]['type'] = 'image';
                        $brandData['tab_image'][0]['size'] = $image->getTabImageSize();
                        $brandData['tab_image'][0]['url'] = $this->getMediaUrl() . $image->getTabImageUrl();
                    }
                }
                $this->loadedData[$item->getId()] = ['banner_fieldset' => $brandData];
            }

            return $this->loadedData;
        }
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
    }

    public function getMediaUrl()
    {
        $media_dir = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $media_dir;
    }
}
