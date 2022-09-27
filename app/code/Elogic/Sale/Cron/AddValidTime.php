<?php

namespace Elogic\Sale\Cron;

use Elogic\Sale\Api\SaleRepositoryInterface;
use Elogic\Sale\Model\ResourceModel\Sale\CollectionFactory;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;

class AddValidTime
{
    private CollectionFactory $saleCollection;
    private SaleRepositoryInterface $saleRepository;
    private CatalogRuleRepositoryInterface $ruleRepository;

    public function __construct(
        CollectionFactory $saleCollection,
        SaleRepositoryInterface $saleRepository,
        CatalogRuleRepositoryInterface $ruleRepository,
    ) {
        $this->saleCollection = $saleCollection;
        $this->saleRepository = $saleRepository;
        $this->ruleRepository = $ruleRepository;
    }

    public function execute()
    {
        $items = $this->saleCollection->create()->getItems();

        foreach ($items as $item) {
            /** @var \Elogic\Sale\Model\Sale $item */

            $timestamp = strtotime($item->getValidUntil()) + 60 * 60;

            $datetime = date('Y-m-d H:i:s', $timestamp);

            $item->setValidUntil($datetime);

            $this->saleRepository->save($item);

            $this->setCatalogPriceRuleValidTime($item->getId(), $datetime);
        }
    }

    private function setCatalogPriceRuleValidTime($ruleId, $datetime)
    {
        try {
            /** @var \Magento\CatalogRule\Model\Rule $rule */
            $rule = $this->ruleRepository->get($ruleId);
        } catch (\Exception $e) {
            return;
        }

        $rule->setToDate($datetime);
        $this->ruleRepository->save($rule);
    }
}
