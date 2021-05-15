<?php

namespace NeoSolax\AdminReview\Controller\Adminhtml\Review;

use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;
use NeoSolax\AdminReview\Model\Review;


class UploadVideo extends \Magento\Backend\App\Action
{

    protected $videoUploader;

    public function __construct(
        Context $context,
        ImageUploader $videoUploader
    ) {

        parent::__construct($context);
        $this->videoUploader = $videoUploader;
    }


    public function execute()
    {
        $videoUploadId = $this->_request->getParam('param_name', 'video_url');
        try {
            $videoResult = $this->videoUploader->saveFileToTmpDir($videoUploadId);

            $videoResult['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $videoResult = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($videoResult);
    }
}
