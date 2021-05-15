<?php
namespace Pulsestorm\ToDoCrud\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Wordoftheday implements ResolverInterface
{
    private $wordofthedayDataProvider;
    /**
     * @param DataProvider\Wordoftheday $wordofthedayRepository
     */
    public function __construct(
        \Pulsestorm\ToDoCrud\Model\Resolver\DataProvider\Wordoftheday $wordofthedayDataProvider
    ) {
        $this->wordofthedayDataProvider = $wordofthedayDataProvider;
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
        //by Date
        $title = $this->getDates($args);
        $wordofthedayData = $this->wordofthedayDataProvider->getWordofthedayByDate($title);
        return $wordofthedayData;
    }

    private function getDates(array $args)
    {
        if (!isset($args['title'])) {
            throw new GraphQlInputException(__('"date should be specified'));
        }
        return $args['title'];
    }
}
