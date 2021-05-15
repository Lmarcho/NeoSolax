<?php

namespace Neosolax\GiftRegistry\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\GiftRegistry\Model\GiftregistryFactory;

class Edit extends Action
{

    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        GiftregistryFactory $giftRegFactory
    ) {
        $this->_giftRegFactory = $giftRegFactory;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();

        if (isset($data['giftregid'])) {
            $post = $this->_giftRegFactory->create()->load($data['giftregid']);
            $post->setTitle($data['title']);
            $post->setDescription($data['description']);
            $post->setEventDate($data['event_date']);
            $post->setStatus($data['status']);
            $post->setBackgroundImage($data['background_image']);
            $post->setShareCode($data['share_code']);
            $post->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('giftregistry/index/index/');
            return $resultRedirect;
        }

        return $this->_pageFactory->create();
    }
}
