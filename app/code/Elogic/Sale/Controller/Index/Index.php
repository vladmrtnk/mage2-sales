<?php

namespace Elogic\Sale\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Index implements HttpGetActionInterface
{
    private $pageFactory;


    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
