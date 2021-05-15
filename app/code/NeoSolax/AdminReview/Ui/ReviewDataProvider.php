<?php

namespace NeoSolax\AdminReview\Ui;

use Magento\Framework\ObjectManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use NeoSolax\AdminReview\Model\ResourceModel\Review\CollectionFactory;

class ReviewDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $addFieldStrategies;
    protected $addFilterStrategies;
    public $_objectManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        ObjectManagerInterface $objectManager,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->_objectManager = $objectManager;
    }

    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();
        return $items;
        $collection = $this->collection->getData();
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => array_values($collection),
        ];
    }
}
