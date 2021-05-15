<?php
namespace NeoSolax\AdminReview\Model;

class Review extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Base media path for banner's image
     */
    const BASE_IMAGE_MEDIA_PATH = 'neosolax/review/image';

    /**
     * Base media path for banner's image
     */
    const BASE_VIDEO_MEDIA_PATH = 'noesolax/review/video';


    protected function _construct()
    {
        $this->_init('NeoSolax\AdminReview\Model\ResourceModel\Review');
    }

}
