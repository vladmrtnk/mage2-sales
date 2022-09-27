<?php

namespace Elogic\Sale\Model\ResourceModel\Sale;

use Elogic\Sale\Model\Sale;
use Elogic\Sale\Model\ResourceModel\Sale as SaleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(Sale::class, SaleResource::class);
    }
}
