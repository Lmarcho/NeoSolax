<?php
namespace Neosolax\GiftRegistry\Helper;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Escaper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Wishlist\Model\Item;

class Data extends AbstractHelper
{
    /**
     * @var Escaper
     */
    protected $escaper;
    /**
     * @var PostHelper
     */
    protected PostHelper $_postDataHelper;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    public function __construct(Context $context, StoreManagerInterface $storeManager, PostHelper $postDataHelper, Escaper $escaper = null)
    {
        $this->_storeManager = $storeManager;
        $this->_postDataHelper = $postDataHelper;
        $this->escaper = $escaper ?? ObjectManager::getInstance()->get(Escaper::class);
        parent::__construct($context);
    }

    protected function _getUrlStore($item)
    {
        $storeId = null;
        $product = null;
        if ($item instanceof Item) {
            $product = $item->getProduct();
        } elseif ($item instanceof Product) {
            $product = $item;
        }
        if ($product) {
            if ($product->isVisibleInSiteVisibility()) {
                $storeId = $product->getStoreId();
            } else {
                if ($product->hasUrlDataObject()) {
                    $storeId = $product->getUrlDataObject()->getStoreId();
                }
            }
        }
        return $this->_storeManager->getStore($storeId);
    }
    /**
     * Retrieve params for adding product to wishlist
     *
     * @param Product|Item $item
     * @param array $params
     * @return string
     */
    public function getAddParams($item, array $params = [])
    {
        $productId = null;
        if ($item instanceof Product) {
            $productId = (int) $item->getEntityId();
        }
        if ($item instanceof Item) {
            $productId = (int) $item->getProductId();
        }

        $url = $this->_getUrlStore($item)->getUrl('giftregistry/index/add');
        if ($productId) {
            $params['product'] = $productId;
        }

        return $this->_postDataHelper->getPostData(
            $this->escaper->escapeUrl($url),
            $params
        );
    }
}
