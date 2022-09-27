<?php

namespace Elogic\Sale\Model\Layer;

use Elogic\Sale\Model\ProductLayer;
use Magento\Framework\ObjectManagerInterface;

class Resolver extends \Magento\Catalog\Model\Layer\Resolver
{
    public function __construct(
        ObjectManagerInterface $objectManager,
        ProductLayer $layer,
        array $layersPool
    ) {
        $this->layer = $layer;
        parent::__construct($objectManager, $layersPool);
    }
}