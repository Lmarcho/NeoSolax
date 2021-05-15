<?php

namespace Neosolax\GiftRegistry\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Neosolax\GiftRegistry\Model\GiftregistryItemsFactory;

class Add extends Action
{
    protected PageFactory $_pageFactory;
    /**
     * @var GiftregistryItemsFactory
     */
    protected GiftregistryItemsFactory $_giftItemsFactory;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        GiftregistryItemsFactory $giftItemsFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_giftItemsFactory= $giftItemsFactory;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function getStoreId()
    {
        $getStoreId= $this->_storeManager->getStore()->getId();
        return $getStoreId;
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();

        if ($data) {
            $giftRegData = [
                'giftregistry_id' => $data['giftreg_id'],
                'product_id' => $data['product_id'],
                'store_id' => $this->getStoreId()
            ];
            $this->_giftItemsFactory->create()->setData($giftRegData)->save();

            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;

//            $resultRedirect = $this->resultRedirectFactory->create();
//            $resultRedirect->setPath('giftregistry/item/index/', ['id' =>$data['giftreg_id']]); // here need to return again previously used page like sign in
//            return $resultRedirect;
        }
        return $this->_pageFactory->create();
    }
}
