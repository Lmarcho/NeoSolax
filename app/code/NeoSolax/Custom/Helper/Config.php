<?php

namespace NeoSolax\Custom\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface;

// What3Words\Helper

class Config extends AbstractHelper
{
    const PREFIX = 'what3words/';
    protected EncryptorInterface $encryptor;

    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->encryptor = $encryptor;
    }

    public function getConfig($area)
    {
        return $this->scopeConfig->getValue(self::PREFIX . $area);
    }

    public function getIsEnabled()
    {
        return $this->getConfig('general/enabled');
    }

    public function getApiKey(): string
    {
        $key = $this->getConfig('general/api_key');
        return $this->encryptor->decrypt($key);
    }

    public function getAllowedCountries()
    {
        return $this->getConfig('general/allowed_countries');
    }
}
