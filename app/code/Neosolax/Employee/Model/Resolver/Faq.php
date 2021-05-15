<?php
namespace Neosolax\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Faq implements ResolverInterface
{
    private $faqDataProvider;

    /**
     * @param DataProvider\Faq $faqDataProvider
     */
    public function __construct(
        DataProvider\Faq $faqDataProvider
    ) {
        $this->faqDataProvider = $faqDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $faqData = $this->faqDataProvider->getFaq();
        return $faqData;
    }
}
