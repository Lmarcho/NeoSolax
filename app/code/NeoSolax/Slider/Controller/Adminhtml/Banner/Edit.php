<?php

namespace NeoSolax\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use NeoSolax\Slider\Model\PwaBanner;

class Edit extends Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        PwaBanner $pwaBanner
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->pwaBanner = $pwaBanner;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('NeoSolax_Slider::banner')
            ->addBreadcrumb(__('ManageBanner'), __('ManageBanner'))
            ->addBreadcrumb(__('Manage Banner'), __('Manage Banner'));
        return $resultPage;
    }

    public function execute()
    {
        $bannerName = "New Item";
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $bannerName = $this->pwaBanner->load($id)->getTitle();
        }
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            __($bannerName),
            __($bannerName)
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Banner'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__($bannerName));

        return $resultPage;
    }
}
