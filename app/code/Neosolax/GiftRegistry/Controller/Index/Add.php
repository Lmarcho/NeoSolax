<?php

namespace Neosolax\GiftRegistry\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\GiftRegistry\Model\GiftregistryFactory;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    /**
     * @var GiftregistryFactory
     */
    protected GiftregistryFactory $_giftregistryFactory;
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;
    /**
     * @var Session
     */
    protected Session $_customerSession;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        GiftregistryFactory $giftregistryFactory,
        Session $customerSession
    ) {
        $this->_giftregistryFactory = $giftregistryFactory;
        $this->_customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer()->getId();
    }

    public function execute()
    {

        $data = $this->getRequest()->getParams();
        if ($data) {
            $giftRegData = [
                'customer_id' => $this->getCustomerId(),
                'giftregistry_type_id' => $data['gifttypeid'],
                'title' => $data['title'],
                'description' => $data['description'],
                'event_date' => $data['event_date'],
                'status' => $data['status'],
                'background_image' => $data['background_image'],
                'share_code' => $data['share_code']
            ];
            $this->_giftregistryFactory->create()->setData($giftRegData)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('giftregistry/index/index/');
            return $resultRedirect;
//            return $this->_redirect($this->_redirect->getRefererUrl());
        }
        return $this->_pageFactory->create();
    }
}
