<?php

namespace Neosolax\GiftRegistry\Block\Giftregistry;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\GiftRegistry\Model\GiftregistryFactory;
use Neosolax\GiftRegistry\Model\GiftregistryTypeFactory;

class Edit extends Template
{
    public function __construct(
        Http $request,
        Context $context,
        PageFactory $pageFactory,
        GiftregistryTypeFactory $giftregtypeFactory,
        GiftregistryFactory $giftRegFactory
    ) {
        $this->request = $request;
        $this->_giftRegFactory = $giftRegFactory;
        $this->pageFactory = $pageFactory;
        $this->_gifttypeFactory = $giftregtypeFactory;
        return parent::__construct($context);
    }

    public function getIddata()
    {
        $this->request->getParams();
        return $this->request->getParam('id');
    }

    public function getResult()
    {
        $post = $this->_giftRegFactory->create()->load($this->getIddata());
        return $post;
    }
    public function getGiftregTypes()
    {
        $post = $this->_gifttypeFactory->create();
        $collection = $post->getCollection();
        return $collection;
    }

    public function getEditRecord()
    {
        return $this->getUrl('giftregistry/index/edit');
    }
}
