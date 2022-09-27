<?php

namespace Elogic\Sale\Controller\Index;

use Elogic\Sale\Model\SaleRepository;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;

class Show implements HttpGetActionInterface
{
    private $pageFactory;
    private $saleRepository;


    public function __construct(
        PageFactory $pageFactory,
        SaleRepository $saleRepository,

    ) {
        $this->pageFactory = $pageFactory;
        $this->saleRepository = $saleRepository;

    }

    public function execute()
    {
        $result = $this->pageFactory->create();

        return $result;
    }
}
