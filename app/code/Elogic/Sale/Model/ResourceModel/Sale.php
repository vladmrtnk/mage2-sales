<?php

namespace Elogic\Sale\Model\ResourceModel;

use Elogic\Sale\Api\Data\SaleInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Sale extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('elogic_sale_entity', SaleInterface::SALE_ID);
    }

    public function checkSlug($slug)
    {
        $select = $this->getConnection()->select()
            ->from('elogic_sale_entity')
            ->columns($this->getIdFieldName())
            ->where(SaleInterface::SLUG . ' = ?', $slug);

        return $this->getConnection()->fetchOne($select);
    }
}
