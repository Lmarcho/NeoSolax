<?php

namespace NeoSolax\AdminReview\Controller\Adminhtml\Review;

use Magento\Framework\Controller\ResultFactory;

class VideoUpload extends \Magento\Backend\App\Action
{
    public $videoUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \NeoSolax\AdminReview\Model\VideoUploader $videoUploader
    ) {
        parent::__construct($context);
        $this->videoUploader = $videoUploader;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('NeoSolax_AdminReview::review');
    }

    public function execute()
    {
        try {
            $result = $this->videoUploader->saveFileToTmpDir('video');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
