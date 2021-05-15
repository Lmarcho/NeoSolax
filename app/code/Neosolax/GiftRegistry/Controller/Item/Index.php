<?php

namespace Neosolax\GiftRegistry\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Neosolax\GiftRegistry\Model\GiftregistryItemsFactory;

class Index extends Action
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
        return $this->_pageFactory->create(); // here need redirect to same page in we get popup message for item add
    }
}
