<?php
namespace Neosolax\Employee\Model\Resolver\DataProvider;

use Neosolax\Crud\Model\Post;

class Faq
{
    protected $_faqFactory;

    public function __construct(
        Post $faqFactory
    ) {
        $this->_faqFactory = $faqFactory;
    }
    /**
     * @params int $id
     * this function return all the word of the day by id
     **/
    public function getFaq()
    {
        try {
            $collection = $this->_faqFactory->getCollection()->getItems();
//            $collection->addFieldToFilter('firstName', 1);
//            $collection->setOrder('short_order', 'ASC');
//            $faqData = $collection->getData();
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $collection;
    }

}
