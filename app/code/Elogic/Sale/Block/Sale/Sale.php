<?php

namespace Elogic\Sale\Block\Sale;

use Elogic\Sale\Api\SaleRepositoryInterface;
use Elogic\Sale\Model\ResourceModel\Sale\CollectionFactory as SaleCollectionFactory;
use Magento\Framework\View\Element\Template;

class Sale extends Template
{
    private $context;
    private $saleCollection;
    private $saleRepository;

    public function __construct(
        Template\Context $context,
        SaleCollectionFactory $saleCollection,
        SaleRepositoryInterface $saleRepository,
        array $data = []
    ) {
        $this->context = $context;
        $this->saleCollection = $saleCollection;
        $this->saleRepository = $saleRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getItems()
    {
        $items = $this->saleCollection->create()->getItems();

        return $items;
    }

    public function getItem()
    {
        $slug = $this->getRequest()->getParam('slug');

        $sale = $this->saleRepository->getBySlug($slug);

        return $sale;
    }
}
