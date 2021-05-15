<?php

namespace NeoSolax\AdminReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\DataObject;
use Magento\Framework\View\Result\PageFactory;
use NeoSolax\AdminReview\Model\ReviewFactory;

class Validate extends Action
{
    protected $resultPageFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        ReviewFactory $reviewFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->reviewFactory = $reviewFactory;
    }

    protected function _validateField($response)
    {
        $messages = [];
        $postdata = $this->getRequest()->getPostValue('review_fieldset');
        $postdata['id'] = isset($postdata['id']) ? $postdata['id'] : "";
        if (!is_array($postdata)) {
            return;
        }
        $data  = $this->reviewFactory->create()->load($postdata['title'], 'title')->getData();
        if (count($data)>0 && $data['id'] != $postdata['id']) {
            $messages[] = __('Code already exist');
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
