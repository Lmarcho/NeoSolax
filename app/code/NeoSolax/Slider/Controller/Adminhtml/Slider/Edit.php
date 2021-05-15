<?php

namespace NeoSolax\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use NeoSolax\Slider\Model\PwaSlider;

class Edit extends Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        PwaSlider $pwaSlider
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->pwaSlider = $pwaSlider;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('NeoSolax_Slider::slider')
            ->addBreadcrumb(__('ManageSlider'), __('ManageSlider'))
            ->addBreadcrumb(__('Manage Slider'), __('Manage Slider'));
        return $resultPage;
    }

    public function execute()
    {
        $sliderName = "New Item";
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $sliderName = $this->pwaSlider->load($id)->getTitle();
        }
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            __($sliderName),
            __($sliderName)
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Slider'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__($sliderName));

        return $resultPage;
    }
}
