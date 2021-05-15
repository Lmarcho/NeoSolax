<?php
namespace Neosolax\GiftRegistry\Block\Giftregistry;

use Magento\Framework\View\Element\Template;
use Neosolax\GiftRegistry\Model\GiftregistryTypeFactory;

class Add extends Template
{
    /**
     * @var GiftregistryTypeFactory
     */
    protected GiftregistryTypeFactory $_gifttypeFactory;

    public function __construct(
        Template\Context $context,
        GiftregistryTypeFactory $giftregtypeFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_gifttypeFactory = $giftregtypeFactory;
    }
    public function getFormUrl()
    {
        return $this->getUrl('giftregistry/index/add');
    }
    public function getGiftregTypes()
    {
        $post = $this->_gifttypeFactory->create();
        $collection = $post->getCollection();
        return $collection;
    }
}
