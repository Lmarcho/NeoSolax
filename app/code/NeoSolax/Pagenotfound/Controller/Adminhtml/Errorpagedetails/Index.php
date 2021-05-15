<?php

namespace NeoSolax\Pagenotfound\Controller\Adminhtml\Errorpagedetails;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('NeoSolax_Pagenotfound::pagenotfound');
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('NeoSolax_Pagenotfound::pagenotfound');
        $resultPage->addBreadcrumb(__('NeoSolax'), __('NeoSolax'));
        $resultPage->addBreadcrumb(__('Pagenotfound'), __('Pagenotfound'));
        return $resultPage;
    }

}
