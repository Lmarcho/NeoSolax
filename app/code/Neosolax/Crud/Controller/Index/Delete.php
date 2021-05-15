<?php

namespace Neosolax\Crud\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\Crud\Model\PostFactory;

class Delete extends Action
{
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        PostFactory $postFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->_postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $post = $this->_postFactory->create();
        $result = $post->setId($id);
        $result = $result->delete();

        return $this->_redirect('crud/index/index');
    }
}
