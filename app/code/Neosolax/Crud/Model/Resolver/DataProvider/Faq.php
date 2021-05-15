<?php
namespace Neosolax\Crud\Model\Resolver\DataProvider;

class Faq
{
    protected $_faqFactory;

    public function __construct(
        \Neosolax\Crud\Model\PostFactory $faqFactory
    ) {
        $this->_faqFactory  = $faqFactory;
    }
    /**
     * @params int $id
     * this function return all the word of the day by id
     **/
    public function getFaq()
    {
        try {
            $collection = $this->_faqFactory->create()->getCollection();
//            $collection->addFieldToFilter('faq_active', 1);
//            $collection->setOrder('short_order', 'ASC');
            $faqData = $collection->getData();
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $faqData;
    }
}
