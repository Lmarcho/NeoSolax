<?php

namespace Pulsestorm\ToDoCrud\Model\Resolver\DataProvider;

class Wordoftheday
{
    protected $_wordofthedayFactory;

    public function __construct(
        \Neosolax\Crud\Model\PostFactory $wordofthedayFactory
    ) {
        $this->_wordofthedayFactory  = $wordofthedayFactory;
    }

    /**
     * @params string $date_to_show
     * this function return all the word of the day by a date
     **/
    public function getWordofthedayByDate(string $firstName): array
    {
        $wordofthedayData = [];
        $collection = $this->_wordofthedayFactory->create()->getCollection();
        $collection->addFieldToFilter('title', $title);
        $collection->getData();

        foreach ($collection as $wod) {
            $wod_id = $wod->getId();
            $wordofthedayData[$wod_id]['title'] = $wod->getTitle();
            $wordofthedayData[$wod_id]['description'] = $wod->getDescription();
        }

        return $wordofthedayData;
        //return $wordofthedayData;
    }//End of function getWordofthedayByDate
}
