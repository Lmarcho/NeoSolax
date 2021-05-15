<?php

namespace NeoSolax\AdminReview\Controller\AdminHtml\Review;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\File\Uploader;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use NeoSolax\AdminReview\Model\Review;
use NeoSolax\AdminReview\Model\ReviewImageFactory;
use NeoSolax\AdminReview\Model\ReviewFactory;
use Psr\Log\LoggerInterface;

class Save extends Action
{

    protected $dataPersistor;
    private $mediaDirectory;
    private $coreFileStorageDatabase;
    private $logger;
    protected $data;
    protected $reviewImageFactory;
    protected $reviewFactory;
    protected $imageUploader;
    protected $videoUploader;

    public function __construct(

        Context $context,
        ImageUploader $imageUploader,
        LoggerInterface $logger,
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        DataPersistorInterface $dataPersistor,
        Review $review,
        ReviewImageFactory $reviewImageFactory,
        ReviewFactory $reviewFactory
    ) {
        $this->logger = $logger;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->dataPersistor = $dataPersistor;
        $this->data = $review;
        $this->reviewImageFactory = $reviewImageFactory;
        $this->reviewFactory = $reviewFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    public function execute()
    {

        $reviewdata = $this->getRequest()->getParam('review_fieldset');
        if(isset($reviewdata)) {
            if(isset($reviewdata['id'])){
                $this->data->load($reviewdata['id']);
                $this->data->setProductId($reviewdata['product_id']);
                $this->data->setEnable($reviewdata['enable']);
                $this->data->setTitle($reviewdata['title']);
                $this->data->setDescription($reviewdata['description']);
                $this->data->save();
                $this->messageManager->addSuccessMessage(__('Success!! Your data is saved.'));
            }else {
                $this->data->setProductId($reviewdata['product_id']);
                $this->data->setEnable($reviewdata['enable']);
                $this->data->setTitle($reviewdata['title']);
                $this->data->setDescription($reviewdata['description']);
                $this->data->setVideoUrl($reviewdata['video_url_upload']);
                $this->data->save();
                $this->messageManager->addSuccessMessage(__('Success!! Your data is saved.'));
            }



//            $image = $this->_request->getParam('image_fieldset');
            if (isset($reviewdata['xlarge_image'])) {
                foreach ($reviewdata['xlarge_image'] as $tmpImg) {
                    $id = $this->data->getId();
                    $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                    if ($reviewImage->getXlargeImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveReviewFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($reviewImage->getData()) {
                                $reviewImage->setXlargeImageUpload($imagePath);
                                $reviewImage->setXlargeImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('xlarge');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->save();
                            } else {
                                $reviewImage = $this->reviewImageFactory->create();
                                $reviewImage->setXlargeImageSequnceId($id);
                                $reviewImage->setXlargeImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('xlarge');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->save();
                            }
                            $this->data->setImageId($reviewImage->getId());
                            $this->data->save();
                        }
                    }

                }
            } else {
                $id = $this->data->getId();
                $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                if ($reviewImage) {
                    $reviewImage->setXlargeImageName();
                    $reviewImage->setDeviceType('xlarge');
                    $reviewImage->setImageSequenceId($reviewdata['product_id']);
                    $reviewImage->setImageUpload();
                    $reviewImage->save();
                }
            }
            if (isset($reviewdata['large_image'])) {
                foreach ($reviewdata['large_image'] as $tmpImg) {
                    $id = $this->data->getId();
                    $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                    if ($reviewImage->getImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveReviewFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($reviewImage->getData()) {
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('large');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->save();
                            } else {
                                $reviewImage = $this->reviewImageFactory->create();
                                $reviewImage->setImageSequnceId($id);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('large');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->save();
                            }
                            $this->data->setImageId($reviewImage->getId());
                            $this->data->save();
                        }
                    }

                }
            } else {
                $id = $this->data->getId();
                $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                if ($reviewImage) {
                    $reviewImage->setImageName();
                    $reviewImage->setDeviceType('large');
                    $reviewImage->setImageSequenceId($reviewdata['product_id']);
                    $reviewImage->setImageUpload();
                    $reviewImage->save();
                }
            }
            if (isset($reviewdata['medium_image'])) {
                foreach ($reviewdata['medium_image'] as $tmpImg) {
                    $id = $this->data->getId();
                    $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                    if ($reviewImage->getImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveReviewFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($reviewImage->getData()) {
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('medium');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->save();
                            } else {
                                $reviewImage = $this->reviewImageFactory->create();
                                $reviewImage->setImageSequnceId($id);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('medium');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->save();
                            }
                            $this->data->setImageId($reviewImage->getId());
                            $this->data->save();
                        }
                    }

                }
            } else {
                $id = $this->data->getId();
                $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', $id)->getFirstItem();
                if ($reviewImage) {
                    $reviewImage->setImageName();
                    $reviewImage->setDeviceType('medium');
                    $reviewImage->setImageSequenceId($reviewdata['product_id']);
                    $reviewImage->setImageUpload();
                    $reviewImage->save();
                }
            }
            if (isset($reviewdata['small_image'])) {
                foreach ($reviewdata['small_image'] as $tmpImg) {
                    $id = $this->data->getId();
                    $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', ($reviewdata['product_id']))->getFirstItem();
                    if ($reviewImage->getImageName() !== $tmpImg['name']) {
                        if (isset($tmpImg['tmp_name'])) {
                            $this->moveReviewFromTmp($tmpImg['name']);
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        } else {
                            $imagePath = "neosolax/review/" . $tmpImg['name'];
                        }
                        if (isset($id)) {
                            if ($reviewImage->getData()) {
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('small');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->save();
                            } else {
                                $reviewImage = $this->reviewImageFactory->create();
                                $reviewImage->setImageSequnceId($id);
                                $reviewImage->setImageName($tmpImg['name']);
                                $reviewImage->setDeviceType('small');
                                $reviewImage->setImageSequenceId($reviewdata['product_id']);
                                $reviewImage->setImageUpload($imagePath);
                                $reviewImage->save();
                            }
                            $this->data->setImageId($reviewImage->getId());
                            $this->data->save();
                        }
                    }

                }
            } else {
                $id = $this->data->getId();
                //recorect image_seq_id as here not id,it should be product id
                $reviewImage = $this->reviewImageFactory->create()->getCollection()->addFieldToFilter('image_sequence_id', ($reviewdata['product_id']))->getFirstItem();
                if ($reviewImage) {
                    $reviewImage->setImageName();
                    $reviewImage->setDeviceType('small');
                    $reviewImage->setImageUpload();
                    $reviewImage->setImageSequenceId($reviewdata['product_id']);
                    $reviewImage->save();
                }
            }

//            if (isset($reviewdata['video_url'])) {
//                $tmpVideo = $this->data->getData($reviewdata['video_url']);
//
//                $id = $this->data->getId();
//                $reviewVideo = $this->reviewFactory->create();
//                if (isset($tmpVideo['tmp_name'])) {
//                    $this->moveReviewFromTmp($tmpVideo['name']);
//                    $imagePath = "neosolax/review/" . $tmpVideo['name'];
//                } else {
//                    $imagePath = "neosolax/review/" . $tmpVideo['name'];
//                }
//                if (isset($id)) {
//                    if ($reviewVideo->getData()) {
//                        $reviewVideo->setVideoUrl($imagePath);
//                        $reviewVideo->setVideoName($tmpImg['name']);
//                        $reviewVideo->save();
//                    } else {
//                        $reviewVideo = $this->review->create();
//                        $reviewVideo->setVideoName($tmpImg['name']);
//                        $reviewVideo->setVideoUrl($imagePath);
//                        $reviewVideo->save();
//                    }
//                    $this->data->save();
//                }

//            }
//            if (isset($reviewdata['video_url'])) {
////                $tmpVideo = $this->data->getData($reviewdata['video_url']);
//                foreach ($reviewdata['video_url'] as $tmpImg) {
//                    $id = $this->data->getId();
//                    $reviewVideo = $this->reviewFactory->create();
//                    if ($reviewVideo->getVideoName() !== $tmpImg['name']) {
//                        if (isset($tmpImg['tmp_name'])) {
//                            $this->moveReviewFromTmp($tmpImg['name']);
//                            $imagePath = "neosolax/review/" . $tmpImg['name'];
//                        } else {
//                            $imagePath = "neosolax/review/" . $tmpImg['name'];
//                        }
//                        if (isset($id)) {
//                            if ($reviewVideo->getData()) {
//                                $reviewVideo->setVideoUrl($imagePath);
//                                $reviewVideo->setVideoName($tmpImg['name']);
//                                $reviewVideo->save();
//                            } else {
//                                $reviewVideo = $this->reviewFactory->create();
//                                $reviewVideo->setVideoName($tmpImg['name']);
//                                $reviewVideo->setVideoUrl($imagePath);
//                                $reviewVideo->save();
//                            }
//                            $this->data->save();
//                        }
//                    }
//
//                }
//            } else {
//                $id = $this->data->getId();
//                $reviewVideo = $this->reviewFactory->create();
//                if ($reviewVideo) {
//                    $reviewVideo->setVideoName();
//                    $reviewVideo->setVideoUrl();
//                    $reviewVideo->save();
//                }
//            }


        } else {
            $this->messageManager->addErrorMessage(__('Error!! Your data is not saved.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('neosolaxreview/review/index');
        return $resultRedirect;
    }


    public function moveReviewFromTmp($imageName, $returnRelativePath = false)
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

}

