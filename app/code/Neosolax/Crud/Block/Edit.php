<?php

namespace Neosolax\Crud\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\Crud\Model\PostFactory;

class Edit extends Template
{
    /**
     * @var Http
     */
    protected Http $request;

    public function __construct(
        Http $request,
        Context $context,
        PageFactory $pageFactory,
        PostFactory $postFactory
    ) {
        $this->request = $request;
        $this->postFactory = $postFactory;
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function getIddata()
    {
        $this->request->getParams();
        return $this->request->getParam('id');
    }

    public function getResult()
    {
        $post = $this->postFactory->create()->load($this->getIddata());
        return $post;
    }

    public function getEditRecord()
    {
        return $this->getUrl('crud/index/edit');
    }
}
