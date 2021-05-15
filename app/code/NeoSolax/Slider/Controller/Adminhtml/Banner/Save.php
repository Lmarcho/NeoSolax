<?php

namespace NeoSolax\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use NeoSolax\Slider\Model\PwaBanner;
use NeoSolax\Slider\Model\SliderImageFactory;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    protected $dataPersistor;
    protected $imageUploader;
    private $pwaBanner;
    private $mediaDirectory;
    private $coreFileStorageDatabase;
    private $logger;
    private $sliderImageFactory;

    public function __construct(
        Context $context,
        LoggerInterface $logger,
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        ImageUploader $imageUploader,
        DataPersistorInterface $dataPersistor,
        PwaBanner $pwaBanner,
        SliderImageFactory $sliderImageFactory
    ) {
        $this->logger = $logger;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->dataPersistor = $dataPersistor;
        $this->pwaBanner = $pwaBanner;
        $this->sliderImageFactory = $sliderImageFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    public function execute()
    {
        $banner = $this->_request->getParam('banner_fieldset');

        if (isset($banner)) {
            if (isset($banner['id'])) {
                $this->pwaBanner->load($banner['id']);
                $this->pwaBanner->setSliderId($banner['slider_id']);
                $this->pwaBanner->setTitle($banner['title']);
                $this->pwaBanner->setDiscription($banner['discription']);
                $this->pwaBanner->setTimeScheduleIn($banner['time_schedule_in']);
                $this->pwaBanner->setTimeScheduleOut($banner['time_schedule_out']);
                $this->pwaBanner->setOrderNumber($banner['order_number']);
                $this->pwaBanner->save();
            } else {
                $this->pwaBanner->setSliderId($banner['slider_id']);
                $this->pwaBanner->setTitle($banner['title']);
                $this->pwaBanner->setDiscription($banner['discription']);
                $this->pwaBanner->setTimeScheduleIn($banner['time_schedule_in']);
                $this->pwaBanner->setTimeScheduleOut($banner['time_schedule_out']);
                $this->pwaBanner->setOrderNumber($banner['order_number']);
                $this->pwaBanner->save();
            }

            if (isset($banner['desktop_image'])) {
                foreach ($banner['desktop_image'] as $tmpImg) {
                    $id = $this->pwaBanner->getId();
                    $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                    if ($bannerImage->getDesktopImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveBannerFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($bannerImage->getData()) {
                                $bannerImage->setDesktopImageUrl($imagePath);
                                $bannerImage->setDesktopImageName($tmpImg['name']);
                                $bannerImage->setDesktopImageSize($tmpImg['size']);
                                $bannerImage->save();
                            } else {
                                $bannerImage = $this->sliderImageFactory->create();
                                $bannerImage->setBannerId($id);
                                $bannerImage->setDesktopImageName($tmpImg['name']);
                                $bannerImage->setDesktopImageSize($tmpImg['size']);
                                $bannerImage->setDesktopImageUrl($imagePath);
                                $bannerImage->save();
                            }
                            $this->pwaBanner->setImageId($bannerImage->getId());
                            $this->pwaBanner->save();
                        }
                    }
                }
            } else {
                $id = $this->pwaBanner->getId();
                $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                if ($bannerImage) {
                    $bannerImage->setDesktopImageName();
                    $bannerImage->setDesktopImageSize();
                    $bannerImage->setDesktopImageUrl();
                    $bannerImage->save();
                }
            }

            if (isset($banner['mobile_image'])) {
                foreach ($banner['mobile_image'] as $tmpImg) {
                    $id = $this->pwaBanner->getId();
                    $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                    if ($bannerImage->getMobileImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveBannerFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($bannerImage->getData()) {
                                $bannerImage->setMobileImageUrl($imagePath);
                                $bannerImage->setMobileImageName($tmpImg['name']);
                                $bannerImage->setMobileImageSize($tmpImg['size']);
                                $bannerImage->save();
                            } else {
                                $bannerImage = $this->sliderImageFactory->create();
                                $bannerImage->setBannerId($id);
                                $bannerImage->setMobileImageName($tmpImg['name']);
                                $bannerImage->setMobileImageSize($tmpImg['size']);
                                $bannerImage->setMobileImageUrl($imagePath);
                                $bannerImage->save();
                            }
                            $this->pwaBanner->setImageId($bannerImage->getId());
                            $this->pwaBanner->save();
                        }
                    }
                }
            } else {
                $id = $this->pwaBanner->getId();
                $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                if ($bannerImage) {
                    $bannerImage->setMobileImageName();
                    $bannerImage->setMobileImageSize();
                    $bannerImage->setMobileImageUrl();
                    $bannerImage->save();
                }
            }

            if (isset($banner['tab_image'])) {
                foreach ($banner['tab_image'] as $tmpImg) {
                    $id = $this->pwaBanner->getId();
                    $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                    if ($bannerImage->getTabImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveBannerFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/banner/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($bannerImage->getData()) {
                                $bannerImage->setTabImageUrl($imagePath);
                                $bannerImage->setTabImageName($tmpImg['name']);
                                $bannerImage->setTabImageSize($tmpImg['size']);
                                $bannerImage->save();
                            } else {
                                $bannerImage = $this->sliderImageFactory->create();
                                $bannerImage->setBannerId($id);
                                $bannerImage->setTabImageName($tmpImg['name']);
                                $bannerImage->setTabImageSize($tmpImg['size']);
                                $bannerImage->setTabImageUrl($imagePath);
                                $bannerImage->save();
                            }
                            $this->pwaBanner->setImageId($bannerImage->getId());
                            $this->pwaBanner->save();
                        }
                    }
                }
            } else {
                $id = $this->pwaBanner->getId();
                $bannerImage = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', $id)->getFirstItem();
                if ($bannerImage) {
                    $bannerImage->setTabImageName();
                    $bannerImage->setTabImageSize();
                    $bannerImage->setTabImageUrl();
                    $bannerImage->save();
                }
            }

            $this->messageManager->addSuccessMessage(__("Details saved Successfully."));
        } else {
            $this->messageManager->addErrorMessage(__("Please add details for Slider."));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('neoslider/banner/index');
        return $resultRedirect;
    }

    public function moveBannerFromTmp($imageName, $returnRelativePath = false)
    {
        $baseTmpPath = $this->imageUploader->getBaseTmpPath();
        $basePath = $this->imageUploader->getBasePath();

        $baseImagePath = $this->imageUploader->getFilePath(
            $basePath,
            Uploader::getNewFileName(
                $this->mediaDirectory->getAbsolutePath(
                    $this->imageUploader->getFilePath($basePath, $imageName)
                )
            )
        );
        $baseTmpImagePath = $this->imageUploader->getFilePath($baseTmpPath, $imageName);

        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Something went wrong while saving the file(s).'),
                $e
            );
        }

        return $returnRelativePath ? $baseImagePath : $imageName;
    }

    public function updateImage($image)
    {
    }
}
