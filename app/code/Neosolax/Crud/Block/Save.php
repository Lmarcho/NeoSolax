<?php

namespace Neosolax\Crud\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;

class Save extends Template
{
    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }

    public function getFormUrl()
    {
        return $this->getUrl('crud/index/save');
    }
}
