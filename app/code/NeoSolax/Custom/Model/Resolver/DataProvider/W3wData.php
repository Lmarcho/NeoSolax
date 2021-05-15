<?php
namespace NeoSolax\Custom\Model\Resolver\DataProvider;


use NeoSolax\Custom\Helper\Config;


class W3wData
{

    protected Config $w3w;

    public function __construct(
        Config $w3w
    ) {
        $this->w3w = $w3w;
    }

    public function getW3wData(): array
    {
        try {
            if ($this->w3w->getIsEnabled()) {
                $apiKey = $this->w3w->getApiKey();
                $allowedCountries = $this->w3w->getAllowedCountries();
                $w3wData=array('apiKey' => $apiKey, 'allowedCountries' => $allowedCountries);
                $nextedArray= array($w3wData);
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $nextedArray;
    }
}
