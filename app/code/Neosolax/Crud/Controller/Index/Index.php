<?php

namespace Neosolax\Crud\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Neosolax\Crud\Model\PostFactory;

class Index extends Action
{
    public function __construct(
        PageFactory $resultPageFactory,
        PostFactory $postFactory,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }

}
