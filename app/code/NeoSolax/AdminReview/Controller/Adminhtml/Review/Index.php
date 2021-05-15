<?php
namespace NeoSolax\AdminReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Neosolax_AdminReview::review');
        $resultPage->getConfig()->getTitle()->prepend(__('Review Grid'));
        return $resultPage;
    }
}

//    protected function _isAllowed()
//    {
//        return $this->_authorization->isAllowed('Neosolax_AdminReview::menu');
//    }
//}
