<?php
/**
 * Class VideoUpload
 *
 * PHP version 7.4
 *
 * @category NeoSolax
 * @package  NeoSolax_AdminReview
 * @author   NeoSolax <magento@neosolax-technologies.com>
 * @license  https://www.neosolax-technologies.com  Open Software License (OSL 3.0)
 * @link     https://www.neosolax-technologies.com
 */
namespace NeoSolax\AdminReview\Block\Adminhtml\Review\Edit\Video;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroup;

/**
 * Class VideoUpload
 *
 * PHP version 7.4
 *
 * @category NeoSolax
 * @package  NeoSolax_AdminReview
 * @author   NeoSolax <magento@neosolax-technologies.com>
 * @license  https://www.neosolax-technologies.com  Open Software License (OSL 3.0)
 * @link     https://www.neosolax-technologies.com
 */
class VideoUpload extends Generic implements TabInterface
{

    /**
     * WysiwygConfig
     *
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $wysiwygConfig;

    /**
     * StoreManager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    protected $systemStore;
    /**
     * @var CustomerGroup
     */
    protected $customerGroup;

    /**
     * Main constructor.
     *
     * @param \Magento\Backend\Block\Template\Context    $context       context
     * @param \Magento\Framework\Registry                $registry      registry
     * @param \Magento\Framework\Data\FormFactory        $formFactory   formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config          $wysiwygConfig wysiwygConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager  storeManager
     * @param array                                      $data          data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\System\Store $systemStore,
        CustomerGroup $customerGroup,
        array $data = []
    ) {

        $this->wysiwygConfig = $wysiwygConfig;
        $this->storeManager = $storeManager;
        $this->systemStore =$systemStore;
        $this->customerGroup = $customerGroup;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare Form
     *
     * @return \Magento\Backend\Block\Widget\Form\Generic
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_model');
        /*
          * Checking if user have permissions to save information
          */
        $isElementDisabled = !$this->_isAllowedAction('NeoSolax_AdminReview::review');

        /**
         * Data Form
         *
         * @var \Magento\Framework\Data\Form $form
         */
        $form = $this->_formFactory->create();

        $fieldset = $form->getFieldset(
            'review_fieldset',
            ['legend' => __('Review Information')]
        );


        if ($model->getProductId()) {
            $fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);
        }

        $reviewType = $fieldset->addField(
            'type',
            'select',
            [
                'label' => 'Type',
                'name' => 'post[type]',
                'required'  => true,
                'values' =>
                    [
                        [
                            'value'    => '',
                            'label'    => 'Select ',
                        ],
                        [
                            'value' => 'Image',
                            'label' => 'Image',
                        ],
                        [
                            'value' => 'Video',
                            'label' => 'Video',
                        ],
                    ],
            ]
        )->setAfterElementHtml(
            '
        <script>
            require([
                 "jquery",
            ], function($){

                $(document).ready(function () {
                    $(".field-image_fieldset").hide();
                    $(".field-video_fieldset").hide();

                    $(".field-video_fieldset_autoplay").hide();
                    $(".field-description").hide();

                    $(function() {

                        if ($("#type").val() == "Image") {
                            $(".field-image_fieldset").show();
                            $(".field-description").show();
                            $(".field-video_fieldset").hide();

                            $(".field-video_fieldset_autoplay").hide();
                        }
                        if ($("#banner_type").val() == "Video") {
                            $(".field-video_fieldset").show();
                            $(".field-video_fieldset_autoplay").show();

                            $(".field-image_fieldset").hide();

                            $(".field-description").hide();
                        }

                    });

                    $("#type").on("change", function() {

                        if($("#type").attr("value") == 0){
                            $(".field-image_fieldset").hide();
                            $(".field-video_fieldset").hide();

                            $(".field-video_fieldset_autoplay").hide();

                            $(".field-banner_description").hide();
                        }

                        if($("#banner_type").attr("value") == "Image"){
                            $(".field-image_fieldset").show();
                            $(".field-video_fieldset").hide();

                            $(".field-video_fieldset_autoplay").hide();


                            $(".field-banner_description").show();
                        }

                        if($("#banner_type").attr("value") == "Video"){
                            $(".field-video_fieldset").show();
                            $(".field-video_fieldset_autoplay").show();

                            $(".field-image_fieldset").hide();

                            $(".field-banner_description").hide();
                        }


                    });
                });
              });
       </script>
    '
        );

        if (is_array($model->getData('image_fieldset'))) {
            $model->setData(
                'image_fieldset',
                $model->getData('image_fieldset')['value']
            );
        }

        $reviewImage = $fieldset->addField(
            'image_fieldset',
            'image',
            [
                'title' => __('Image'),
                'label' => __('Image'),
                'name' => 'post[banner_image]',
                'required' => true,
                'value' => $model->getData('image_fieldset'),
                'note' => __('Note : Please upload image 1920 x 650 (width x height) size with jpg, jpeg, gif, png format'),
            ]
        )->setAfterElementHtml(
            '
        <script>
            require([
                 "jquery",
            ], function($){
                $(document).ready(function () {
                    if($("#image_fieldset").attr("value")){
                        $("#image_fieldset").removeClass("required-file");
                    }else{
                        $("#image_fieldset").addClass("required-file");
                    }
                    $( "#image_fieldset" ).attr( "accept", "image/x-png,image/gif,image/jpeg,image/jpg,image/png" );
                });
              });
       </script>
    '
        );

        if (is_array($model->getData('video_fieldset'))) {
            $model->setData(
                'video_fieldset',
                $model->getData('video_fieldset')['value']
            );
        }
        $reviewVideo = $fieldset->addField(
            'video_fieldset',
            'file',
            [
                'title' => __('Video'),
                'label' => __('Video'),
                'name' => 'post[video_fieldset]',
                'value' => $model->getData('video_fieldset'),
                'note' => __('Note : Please upload video with mp4 format'),
            ]
        )->setAfterElementHtml(
            '<div>
                <a href="'.  $this->getMediaUrl() . $model->getData('video_fieldset') . '" target="_blank">'
            . substr($model->getData("video_fieldset"), strrpos($model->getData("video_fieldset"), "/")+1) . '
                </a>
            </div>
            <script>
                require([
                     "jquery",
                ], function($){
                    $(document).ready(function () {
                        if($("#video_fieldset").attr("value")){
                            $("#video_fieldset").removeClass("required-file");
                        }else{
                            $("#video_fieldset").addClass("required-file");
                        }
                        $( "#video_fieldset" ).attr( "accept", "video/mp4" );
                    });
                  });
            </script>'
        );


        $fieldset->addField(
            'video_fieldset_autoplay',
            'select',
            [
                'name'      => 'post[video_fieldset_autoplay]',
                'label'     => __('Autoplay'),
                'title'     => __('Autoplay'),
                'values' => [
                    ['value'=>'1','label'=>'Yes'],
                    ['value'=>'0','label'=>'No'],
                ],
                'required'  => false,
                'checked' => 'checked',
                'disabled' => $isElementDisabled
            ]
        );

        $this->setChild(
            'form_after',
            $this->getLayout()
                ->createBlock(\Magento\Backend\Block\Widget\Form\Element\Dependence::class)
                ->addFieldMap($reviewType->getHtmlId(), $reviewType->getName())
                ->addFieldMap($reviewImage->getHtmlId(), $reviewImage->getName())
                ->addFieldMap($reviewVideo->getHtmlId(), $reviewVideo->getName())

                ->addFieldDependence($reviewImage->getName(), $reviewType->getName(), 'Image')
                ->addFieldDependence($reviewVideo->getName(), $reviewType->getName(), 'Video')

        );

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        // Setting custom renderer for content field to remove label column
        $renderer = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element::class
        );


        $this->_eventManager->dispatch(
            'neosolax_review_post_edit_video_videoupload_prepare_form',
            ['form' => $form]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Return Base Media Url
     *
     * @return mixed
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

    /**
     * Generate spaces
     *
     * @param int $n no of spaces
     *
     * @return string
     */
    protected function _getSpaces($n)
    {
        $s = '';
        for ($i = 0; $i < $n; $i++) {
            $s .= '--- ';
        }

        return $s;
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Banner  Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Banner Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
