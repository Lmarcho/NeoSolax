<?php

namespace Neosolax\GiftRegistry\Block\Giftregistry;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ProductList\Item\Block;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Neosolax\GiftRegistry\Helper\Data;
use Neosolax\GiftRegistry\Model\GiftregistryFactory;

class Index extends Block
{
    /**
     * @var GiftregistryFactory
     */
    protected GiftregistryFactory $_giftregistryFactory;
    /**
     * @var Session
     */
    protected Session $_customerSession;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $_urlInterface;
    /**
     * @var Redirect
     */
    protected Redirect $_resultRedirect;

    public function __construct(
        Http $request,
        Context $context,
        StoreManagerInterface $storeManager,
        Data $helper,
        Http $response,
        Registry $registry,
        Session $session,
        UrlInterface $urlInterface,
        ResultFactory $resultFactory,
        GiftregistryFactory $giftregistryFactory,
        RedirectInterface $redirect,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->_helper = $helper;
        $this->_registry = $registry;
        $this->_request = $request;
        $this->_customerSession = $session;
        $this->_giftregistryFactory = $giftregistryFactory;
        $this->_response = $response;
        $this->resultFactory = $resultFactory;
        $this->_urlInterface = $urlInterface;
        $this->_redirect = $redirect;
        parent::__construct($context, $data);
    }

    public function checkGiftregistryListEmpty()
    {
        //test
    }
    public function getStoreId()
    {
        $getStoreId= $this->_storeManager->getStore()->getId();
        return $getStoreId;
    }

    public function getAddGiftItemUrl($product, $giftregId)
    {
        return $this->getUrl('giftregistry/item/add', ['product_id' => $product->getId(),'giftreg_id' =>$giftregId]);
    }
    public function getEditGiftReg()
    {
        return$this->getUrl('giftregistry/index/edit');
    }
    public function getViewGiftReg()
    {
        return$this->getUrl('giftregistry/index/view');
    }
    public function getDeleteGiftReg()
    {
        return$this->getUrl('giftregistry/index/view');
    }

    public function getSignIn()
    {
        $url = $this->_redirect->getRefererUrl();
        $login_url = $this->_urlInterface
            ->getUrl(
                'customer/account/login',
                ['referer' => base64_encode($url)]
            );
        return $login_url;

//        /** @var Redirect $resultRedirect */
//        $resultRedirect = $this->resultFactory->create();
//        $resultRedirect->setUrl($login_url);
//        return $resultRedirect;

//        return $this->getUrl('customer/account/login');
    }

    public function getIddata()
    {
        $this->_request->getParams();
        return $this->_request->getParam('id');
    }

    public function getGiftRegParams()
    {
        $product = $this->getProduct();
        return $this->_helper->getAddParams($product);
    }

    public function getGiftregistryList()
    {
        $giftreg = $this->_giftregistryFactory->create()->load($this->getIddata());
        return $giftreg;
    }

    public function getAddNewGiftRegUrl()
    {
        return $this->getUrl('giftregistry/index/add');
    }

    public function selectGiftRegistry($product)
    {
        return $this->getUrl('giftregistry/index/index', ['product_id' => $product->getId()]);
    }

    public function isLog()
    {
        return $this->_customerSession->isLoggedIn();
    }
    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer()->getId();
    }

    public function getResult()
    {
        return   $this->_giftregistryFactory->create()->
        getCollection()->
        addFieldToSelect('*')->
        addFieldToFilter('customer_id', $this->getCustomerId());
    }
}
