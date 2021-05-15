<?php

namespace NeoSolax\Slider\Model\Resolver;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use NeoSolax\Slider\Model\PwaBannerFactory;
use NeoSolax\Slider\Model\PwaSliderFactory;
use NeoSolax\Slider\Model\SliderImageFactory;

class HomeSlider implements ResolverInterface
{
    private $valueFactory;
    private $serviceOutputProcessor;
    private $dataObjectConverter;
    private $logger;

    public function __construct(
        ValueFactory $valueFactory,
        ServiceOutputProcessor $serviceOutputProcessor,
        ExtensibleDataObjectConverter $dataObjectConverter,
        \Psr\Log\LoggerInterface $logger,
        PwaSliderFactory $pwaSliderFactory,
        PwaBannerFactory $pwaBannerFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        SliderImageFactory $sliderImageFactory
    ) {
        $this->timezone = $timezone;
        $this->valueFactory = $valueFactory;
        $this->serviceOutputProcessor = $serviceOutputProcessor;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->logger = $logger;
        $this->pwaSliderFactory = $pwaSliderFactory;
        $this->pwaBannerFactory = $pwaBannerFactory;
        $this->sliderImageFactory = $sliderImageFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
//        if (!isset($args['slider_id'])) {
//            throw new GraphQlAuthorizationException(
//                __(
//                    'Slider_id  should be specified',
//                    [\Magento\Customer\Model\Customer::ENTITY]
//                )
//            );
//        }
        try {
            $data['slider'] = $this->getSliderData();
            $data['banner'] = $this->getBannerData($data['slider']['id']);

            $result = function () use ($data) {
                return !empty($data) ? $data : [];
            };
            return $this->valueFactory->create($result);
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        } catch (LocalizedException $exception) {
            throw new GraphQlNoSuchEntityException(__($exception->getMessage()));
        }
    }

    private function getSliderData(): array
    {
        try {
            $sliderData = [];
            $sliderColl = $this->pwaSliderFactory->create()->getCollection()->addFieldToFilter('use_homeslider', ['eq' => 'homeslider']);
            if ($sliderColl->getSize() > 0) {
                foreach ($sliderColl as $slider) {
                    if ($slider->getStatus() == 1) {
                        array_push($sliderData, $slider->getData());
                    } else {
                        throw new GraphQlAuthorizationException(
                            __(
                                'Not Home Slider is disable',
                                [\Magento\Customer\Model\Customer::ENTITY]
                            )
                        );
                    }
                }
                return isset($sliderData[0]) ? $sliderData[0] : [];
            } else {
                throw new GraphQlAuthorizationException(
                    __(
                        'Not Home Slider is defined',
                        [\Magento\Customer\Model\Customer::ENTITY]
                    )
                );
            }
        } catch (NoSuchEntityException $e) {
            return [];
        } catch (LocalizedException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }

    private function getBannerData($sliderId): array
    {
        try {
            $bannerData = [];
            $bannerColl = $this->pwaBannerFactory->create()->getCollection()->addFieldToFilter('slider_id', ['eq' => $sliderId])->setOrder('order_number', 'ASC');
            $i = 0;
            foreach ($bannerColl as $banner) {
                $timezone = $this->timezone->getConfigTimezone();
                date_default_timezone_set($timezone);
                $currenttime =date("Y-m-d H:i:s");
                if ($currenttime >= $banner->getTimeScheduleIn() && $currenttime <= $banner->getTimeScheduleOut()) {
                    array_push($bannerData, $banner->getData());
                    if ($banner->getId()) {
                        $bannerData[$i]['images'] = $this->getImagesData($banner->getId());
                    }
                    $i++;
                }
            }
            return isset($bannerData) ? $bannerData : [];
        } catch (NoSuchEntityException $e) {
            return [];
        } catch (LocalizedException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }

    private function getImagesData($bannerId): array
    {
        try {
            $imagesData = [];
            $imagesColl = $this->sliderImageFactory->create()->getCollection()->addFieldToFilter('banner_id', ['eq' => $bannerId]);
            foreach ($imagesColl as $images) {
                array_push($imagesData, $images->getData());
            }
            return $imagesData[0];
        } catch (NoSuchEntityException $e) {
            return [];
        } catch (LocalizedException $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }
}
