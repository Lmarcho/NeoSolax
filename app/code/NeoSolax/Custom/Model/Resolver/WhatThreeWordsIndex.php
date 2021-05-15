<?php
namespace NeoSolax\Custom\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class WhatThreeWordsIndex implements ResolverInterface
{
    private $w3wDataProvider;

    public function __construct(
        DataProvider\W3wData $w3wDataProvider
    ) {
        $this->w3wDataProvider = $w3wDataProvider;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $w3wData = $this->w3wDataProvider->getW3wData();
        return $w3wData;
    }
}
