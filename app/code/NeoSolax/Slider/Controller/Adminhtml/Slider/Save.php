<?php

namespace NeoSolax\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use NeoSolax\Slider\Model\PwaSlider;

class Save extends Action
{
    protected $dataPersistor;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        PwaSlider $pwaslider
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->pwaslider = $pwaslider;
        parent::__construct($context);
    }

    public function execute()
    {

        $slider = $this->_request->getParam('slider_fieldset');

        $filePath = [];
        if (isset($slider)) {
            if (isset($slider['id'])) {
                $this->pwaslider->load($slider['id']);
                $this->pwaslider->setTitle($slider['title']);
                $this->pwaslider->setDiscription($slider['discription']);
                $this->pwaslider->setStatus($slider['status']);
                $this->pwaslider->setUseHomeslider($slider['use_homeslider']);
                $this->pwaslider->setTime($slider['time']);
                $this->pwaslider->setWidth($slider['width']);
                $this->pwaslider->setHight($slider['hight']);
                $this->pwaslider->save();
            } else {
                $this->pwaslider->setTitle($slider['title']);
                $this->pwaslider->setDiscription($slider['discription']);
                $this->pwaslider->setStatus($slider['status']);
                $this->pwaslider->setUseHomeslider($slider['use_homeslider']);
                $this->pwaslider->setTime($slider['time']);
                $this->pwaslider->setWidth($slider['width']);
                $this->pwaslider->setHight($slider['hight']);
                $this->pwaslider->save();
            }
            $this->messageManager->addSuccessMessage(__("Details saved Successfully."));
        } else {
            $this->messageManager->addErrorMessage(__("Please add details for Slider."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('neoslider/slider/index');
        return $resultRedirect;
    }
}
