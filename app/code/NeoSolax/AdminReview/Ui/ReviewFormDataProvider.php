<?php

namespace NeoSolax\AdminReview\Ui;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use NeoSolax\AdminReview\Model\ResourceModel\Review\CollectionFactory;
use NeoSolax\AdminReview\Model\ReviewImageFactory;

class ReviewFormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $addFieldStrategies;
    protected $addFilterStrategies;
    public $_objectManager;
    protected $_request;
    protected  $reviewImageFactory;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        ReviewImageFactory $reviewImageFactory,
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
        $this->storeManager = $storeManager;
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->_objectManager = $objectManager;
        $this->reviewImageFactory = $reviewImageFactory;
        $this->_request = $request;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $itemId = $this->_request->getParam('id');

        if (!empty($itemId)) {
            $items = $this->collection->getItems();
            $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $itemId);
            foreach ($items as $item) {
                $data = $item->getData();

                $this->loadedData[$item->getId()] = ['review_fieldset' => $data];
//
                foreach ($reviewImage as $image) {
                    if ( [$image->getDeiceType()->getAttributeText('device_type')] == "small") {
                        $data['small_image'][0]['name'] = $image->getImageName();
                        $data['small_image'][0]['type'] = 'image';
                        $data['small_image'][0]['size'] = $image->getImageSize();
                        $data['small_image'][0]['url'] = $this->getMediaUrl() . $image->getImageUrl();
                    }
                    if ([$image->getDeiceType()->getAttributeText('device_type')] == "medium") {
                        $data['medium_image'][0]['name'] = $image->getImageName();
                        $data['medium_image'][0]['type'] = 'image';
                        $data['medium_image'][0]['size'] = $image->getImageSize();
                        $data['medium_image'][0]['url'] = $this->getMediaUrl() . $image->getImageUrl();
                    }
                    if ([$image->getDeiceType()->getAttributeText('device_type')] == "large") {
                        $data['large_image'][0]['name'] = $image->getImageName();
                        $data['large_image'][0]['type'] = 'image';
                        $data['large_image'][0]['size'] = $image->getImageSize();
                        $data['large_image'][0]['url'] = $this->getMediaUrl() . $image->getImageUrl();
                    }
                    if ([$image->getDeiceType()->getAttributeText('device_type')] == "xlarge") {
                        $data['xlarge_image'][0]['name'] = $image->getImageName();
                        $data['xlarge_image'][0]['type'] = 'image';
                        $data['xlarge_image'][0]['size'] = $image->getImageSize();
                        $data['xlarge_image'][0]['url'] = $this->getMediaUrl() . $image->getImageUrl();
                    }
                }
                $this->loadedData[$item->getId()] = ['review_fieldset' => $data];

            }

            return $this->loadedData;
        }
//
    }

    public function getMediaUrl()
    {
        $media_dir = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $media_dir;
    }
}
