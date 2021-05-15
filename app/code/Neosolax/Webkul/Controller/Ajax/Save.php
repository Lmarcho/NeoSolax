<?php

namespace Neosolax\Webkul\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Json\Helper\Data;

class Save extends Action
{
    protected $helper;

    protected $resultJsonFactory;

    protected $resultRawFactory;

    public function __construct(
        Context $context,
        Data $helper,
        JsonFactory $resultJsonFactory,
        RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
    }
    public function execute()
    {
        $model = $this->_objectManager->create('Neosolax\Webkul\Model\CustomerData');
        $credentials = $this->helper->jsonDecode($this->getRequest()->getContent());
        $model->setData($credentials)->save();

        $collection = $model->getCollection();
        foreach ($collection as $data) {
            $response[] = ['name' => $data->getName(), 'email' => $data->getEmail()];
        }
        /** @var Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
