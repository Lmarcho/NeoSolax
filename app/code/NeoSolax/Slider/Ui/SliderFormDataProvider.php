<?php

namespace NeoSolax\Slider\Ui;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use NeoSolax\Slider\Model\ResourceModel\PwaSlider\CollectionFactory;

class SliderFormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $addFieldStrategies;
    protected $addFilterStrategies;
    public $_objectManager;
    protected $_request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
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
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $itemId = $this->_request->getParam('id');

        if (!empty($itemId)) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $brandData = $item->getData();
                $this->loadedData[$item->getId()] = ['slider_fieldset' => $brandData];
            }
            return $this->loadedData;
        }
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
    }
}
