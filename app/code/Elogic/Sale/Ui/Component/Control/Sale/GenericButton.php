<?php

namespace Elogic\Sale\Ui\Component\Control\Sale;

use Elogic\Sale\Model\SaleRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    private UrlInterface $urlBuilder;
    private RequestInterface $request;
    private SaleRepository $saleRepository;

    public function __construct(
        UrlInterface $urlBuilder,
        RequestInterface $request,
        SaleRepository $saleRepository
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->saleRepository = $saleRepository;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    public function getSale()
    {
        $saleId = $this->request->getParam('id');
        if ($saleId === null) {
            return 0;
        }
        $sale = $this->saleRepository->get($saleId);

        return $sale->getId() ?: null;
    }
}

