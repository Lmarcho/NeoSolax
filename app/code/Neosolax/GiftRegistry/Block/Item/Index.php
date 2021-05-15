<?php
namespace Neosolax\GiftRegistry\Block\Item;

use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Neosolax\GiftRegistry\Model\GiftregistryItemsFactory;

class Index extends Template
{
    protected $pageFactory;
    /**
     * @var GiftregistryItemsFactory
     */
    protected GiftregistryItemsFactory $_giftregitemsFactory;
    /**
     * @var ProductRepositoryInterfaceFactory
     */
    protected ProductRepositoryInterfaceFactory $_productRepositoryFactory;
    /**
     * @var ProductFactory
     */
    protected ProductFactory $productFactory;
    /**
     * @var Image
     */
    protected Image $imageHelper;

    public function __construct(
        Template\Context $context,
        GiftregistryItemsFactory $giftregistryItemsFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productrepository,
        \Magento\Store\Model\StoreManagerInterface $storemanager,
        Image $imageHelper,
        ProductFactory $productFactory,
        Http $request,
        array $data = []
    ) {
        $this->_request = $request;
        $this->_giftregitemsFactory = $giftregistryItemsFactory;
        $this->_productCollectionFactory = $productFactory;
        $this->productrepository = $productrepository;
        $this->_storeManager =  $storemanager;
        $this->imageHelper = $imageHelper;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }
    public function getFormUrl()
    {
        return $this->getUrl('giftregistry/index/add');
    }
    public function getGiftRegID()
    {
        return $this->_request->getParam('id');
    }
    public function getProductId()
    {
        return   $this->_giftregitemsFactory->create()->
        getCollection()->
        addFieldToSelect('product_id')->
        addFieldToFilter('giftregistry_id', $this->getGiftRegID());
    }
    public function getResult()
    {
        return   $this->_giftregitemsFactory->create()->
        getCollection()->
        addFieldToSelect('*')->
        addFieldToFilter('giftregistry_id', $this->getGiftRegID());
    }
    public function getProductImageUrl($id)
    {
        try {
            $product = $this->productFactory->create()->load($id);
        } catch (NoSuchEntityException $e) {
            return 'Data not found';
        }
        $url = $this->imageHelper->init($product, 'product_small_image')->getUrl();
        return $url;
    }
    public function getBackUrl()
    {
        return $this->getUrl('giftregistry/index/');
    }
    public function hasGiftregistryItems()
    {
        return true; // need to implement
    }
}
