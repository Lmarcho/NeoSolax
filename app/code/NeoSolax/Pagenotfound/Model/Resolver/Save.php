<?php

namespace NeoSolax\Pagenotfound\Model\Resolver;

use Magento\Email\Model\Template\Config;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthenticationException;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Webapi\ServiceOutputProcessor;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use NeoSolax\Pagenotfound\Model\Pagenotfound;

class Save implements ResolverInterface
{
    const SENDER_EMAIL = 'trans_email/ident_support/email';
    private $valueFactory;
    private $serviceOutputProcessor;
    private $dataObjectConverter;
    /**
     * @var Pagenotfound
     */
    protected Pagenotfound $pagenotfound;
    protected ScopeConfigInterface $scopeConfig;
    /**
     * @var StateInterface
     */
    protected StateInterface $inlineTranslation;
    protected TransportBuilder $_transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;
    /**
     * @var Config
     */
    protected Config $emailTemplateConfig;

    public function __construct(
        ValueFactory $valueFactory,
        ServiceOutputProcessor $serviceOutputProcessor,
        ExtensibleDataObjectConverter $dataObjectConverter,
        Pagenotfound $pagenotfound,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Config $emailTemplateConfig
    ) {
        $this->valueFactory = $valueFactory;
        $this->serviceOutputProcessor = $serviceOutputProcessor;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->pagenotfound = $pagenotfound;

        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->emailTemplateConfig = $emailTemplateConfig;
    }

    public function senderEmail($type = null, $storeId = null)
    {
        $sender ['email'] = $this->scopeConfig->getValue(
            self::SENDER_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        $sender['name'] = 'admin';

        return $sender;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $errorUrlData = $args['errorUrlData'];
        $customerIp = $args['customerIp'];
        $storeId = $this->storeManager->getStore()->getId();

        $msg = null;
        $error = true;

        try {
            $this->pagenotfound->setUrl($errorUrlData);
            $this->pagenotfound->setClientIp($customerIp);
            $this->pagenotfound->setStoreId($storeId);
            $this->pagenotfound->save();
        } catch (AuthenticationException $e) {
            $msg = $e->getMessage();
        }

        $storeScope = ScopeInterface::SCOPE_STORE;

        $ownerEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $adminEmail = $this->senderEmail();

        $this->inlineTranslation->suspend();
        $transport = $this->_transportBuilder
            ->setTemplateIdentifier('pagenotfound_email')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['url' => $errorUrlData, 'clientip' => $customerIp, 'reqdate' => date('Y-m-d H:i:s')])
            ->setFrom($adminEmail)
            ->addTo($ownerEmail)
            ->getTransport();

        $transport->sendMessage();
        $this->inlineTranslation->resume();

        try {
            return [
                'msg' => $msg,
                'error' => $error
            ];
        } catch (AuthenticationException $e) {
            throw new GraphQlAuthenticationException(__($e->getMessage()), $e);
        }
    }
}
