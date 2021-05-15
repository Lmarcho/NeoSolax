<?php

namespace NeoSolax\AdminReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use NeoSolax\AdminReview\Model\Review;

class Edit extends Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Review $review
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->review = $review;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('NeoSolax_AdminReview::review')
            ->addBreadcrumb(__('ManageReview'), __('ManageReview'))
            ->addBreadcrumb(__('Manage Review'), __('Manage Review'));
        return $resultPage;
    }

    public function execute()
    {
        $reviewName = "New Review";
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $reviewName = $this->review->load($id)->getTitle();
        }
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            __($reviewName),
            __($reviewName)
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Review'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__($reviewName));

        return $resultPage;
    }
}
