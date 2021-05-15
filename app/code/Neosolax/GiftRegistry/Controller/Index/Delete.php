<?php

namespace Neosolax\GiftRegistry\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\GiftRegistry\Model\GiftregistryFactory;

class Delete extends Action
{
    /**
     * @var GiftregistryFactory
     */
    protected GiftregistryFactory $_giftRegFactory;
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        GiftregistryFactory $giftRegFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->_giftRegFactory = $giftRegFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $post = $this->_giftRegFactory->create();
        $result = $post->setId($id);
        $result = $result->delete();

        return $this->_redirect('giftregistry/index/index');
    }
}
