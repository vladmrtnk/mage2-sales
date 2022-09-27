<?php

namespace Elogic\Sale\Model\Source;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Products implements \Magento\Framework\Option\ArrayInterface
{
    protected $_productCollectionFactory;

    public function __construct(
        CollectionFactory $productCollectionFactory
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    public function toOptionArray()
    {
        $collection = $this->_productCollectionFactory
            ->create()
            ->addAttributeToSelect('name');

        $options = [];

        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection as $product) {
            $options[] = ['label' => $product->getName(), 'value' => $product->getId()];
        }

        return $options;
    }
}
