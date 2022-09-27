<?php

namespace Elogic\Sale\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\ContextInterface;
use Magento\Catalog\Model\Layer\StateFactory;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\BlockFactory;
use Magento\Store\Model\StoreManagerInterface;

class ProductLayer extends Layer
{
    /**
     * @var \Magento\Framework\View\Element\BlockFactory
     */
    protected $_blockFactory;

    /**
     * @param  Layer\ContextInterface  $context
     * @param  Layer\StateFactory  $layerStateFactory
     * @param  AttributeCollectionFactory  $attributeCollectionFactory
     * @param  \Magento\Catalog\Model\ResourceModel\Product  $catalogProduct
     * @param  \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param  \Magento\Framework\Registry  $registry
     * @param  CategoryRepositoryInterface  $categoryRepository
     * @param  array  $data
     */
    public function __construct(
        ContextInterface $context,
        StateFactory $layerStateFactory,
        AttributeCollectionFactory $attributeCollectionFactory,
        Product $catalogProduct,
        StoreManagerInterface $storeManager,
        Registry $registry,
        CategoryRepositoryInterface $categoryRepository,
        BlockFactory $blockFactory,
        array $data = []
    ) {
        $this->_blockFactory = $blockFactory;
        parent::__construct(
            $context,
            $layerStateFactory,
            $attributeCollectionFactory,
            $catalogProduct,
            $storeManager,
            $registry,
            $categoryRepository,
            $data
        );
    }

    public function getProductCollection()
    {
        $collection = parent::getProductCollection();

        $block = $this->_blockFactory->createBlock('Elogic\Sale\Block\Sale\Sale');

        /** @var \Elogic\Sale\Block\Sale\Sale $block */
        $products = $block->getItem()->getProducts();

        $collection->addIdFilter($products);

        return $collection;
    }
}
