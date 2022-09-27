<?php

namespace Elogic\Sale\Model;

use Elogic\Sale\Api\Data\SaleInterface;
use Elogic\Sale\Api\SaleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class SaleRepository implements SaleRepositoryInterface
{
    private $collectionFactory;
    private $saleFactory;
    private $saleResource;
    private $searchResultFactory;

    public function __construct(
        \Elogic\Sale\Model\SaleFactory $saleFactory,
        \Elogic\Sale\Model\ResourceModel\Sale\CollectionFactory $collectionFactory,
        \Elogic\Sale\Model\ResourceModel\Sale $saleResource,
        \Elogic\Sale\Api\SaleSearchResultInterfaceFactory $searchResultInterfaceFactory,
    ) {
        $this->saleFactory = $saleFactory;
        $this->collectionFactory = $collectionFactory;
        $this->saleResource = $saleResource;
        $this->searchResultFactory = $searchResultInterfaceFactory;
    }

    public function get($saleId)
    {
        $saleObject = $this->saleFactory->create();
        $this->saleResource->load($saleObject, $saleId);

        if (!$saleObject->getId()) {
            throw new NoSuchEntityException(__('Unable to find sale with ID "%value"', ['value' => $saleId]));
        }

        return $saleObject;
    }

    public function getBySlug($slug)
    {
        $saleObject = $this->saleFactory->create();
        $this->saleResource->load($saleObject, $slug, SaleInterface::SLUG);

        if (!$saleObject->getId()) {
            throw new NoSuchEntityException(__('Unable to find sale with slug "%value"', ['value' => $slug]));
        }

        return $saleObject;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    public function save(SaleInterface $sale)
    {
        $this->saleResource->save($sale);

        return $sale;
    }

    public function delete(SaleInterface $sale)
    {
        try {
            $this->saleResource->delete($sale);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity with ID "%value"', ['value' => $sale->getId()]));
        }

        return true;
    }
}
