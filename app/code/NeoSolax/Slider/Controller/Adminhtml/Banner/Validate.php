<?php

namespace NeoSolax\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\DataObject;
use Magento\Framework\View\Result\PageFactory;
use NeoSolax\Slider\Model\PwaBannerFactory;

class Validate extends Action
{
    protected $resultPageFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        PwaBannerFactory $pwaBannerFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->pwaBannerFactory = $pwaBannerFactory;
    }

    protected function _validateField($response)
    {
        $messages = [];
        $postdata = $this->getRequest()->getPostValue('banner_fieldset');
        $postdata['id'] = isset($postdata['id']) ? $postdata['id'] : "";
        if (!is_array($postdata)) {
            return;
        }
        $slider  = $this->pwaBannerFactory->create()->load($postdata['title'], 'title')->getData();
        if (count($slider)>0 && $slider['id'] != $postdata['id']) {
            $messages[] = __('Banner Code already exist');
            $response->setMessages($messages);
            $response->setError(1);
        }
    }

    public function execute()
    {
        $response = new DataObject();
        $response->setError(0);

        $customer = $this->_validateField($response);

        $resultJson = $this->resultJsonFactory->create();
        if ($response->getError()) {
            $response->setError(true);
            $response->setMessages($response->getMessages());
        }

        $resultJson->setData($response);
        return $resultJson;
    }
}
