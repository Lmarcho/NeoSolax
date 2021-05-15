<?php

namespace Neosolax\Employee\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Neosolax\Crud\Model\PostFactory;

class Index extends Template
{

    public function __construct(
        Context $context,
        PostFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    public function getResult()
    {
        $post = $this->postFactory->create();
        $collection = $post->getCollection();
        return $collection;
    }
}


