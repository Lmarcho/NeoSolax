<?php

namespace Neosolax\GiftRegistry\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_pageFactory;
    /**
     * @var Session
     */
    protected Session $_customerSession;
    /**
     * @var UrlInterface
     */
    protected UrlInterface $_urlInterface;

    public function __construct(
        Context $context,
        Session $session,
        UrlInterface $urlInterface,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_customerSession = $session;
        $this->_urlInterface = $urlInterface;
        return parent::__construct($context);
    }
    public function isLog()
    {
        return $this->_customerSession->isLoggedIn();
    }
//    public function getSignIn()
//    {
//        return $this->getUrl('customer/account/login');
//    }

    public function execute()
    {
        if ($this->isLog()) {
            return $this->_pageFactory->create();
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('customer/account/login');
        return $resultRedirect;

    }
}
