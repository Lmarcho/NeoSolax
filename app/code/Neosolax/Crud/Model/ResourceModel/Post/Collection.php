<?php

namespace Neosolax\Crud\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'employee_id';
    protected $_eventPrefix = 'neosolax_crud_form_collection';
    protected $_eventObject = 'form_collection';


    protected function _construct()
    {
        $this->_init('Neosolax\Crud\Model\Post', 'Neosolax\Crud\Model\ResourceModel\Post');
    }

}

