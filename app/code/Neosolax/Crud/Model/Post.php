<?php

namespace Neosolax\Crud\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'neosolax_crud_form';

    protected $_cacheTag = 'neosolax_crud_form';

    protected $_eventPrefix = 'neosolax_crud_form';

    protected function _construct()
    {
        $this->_init('Neosolax\Crud\Model\ResourceModel\Post');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
