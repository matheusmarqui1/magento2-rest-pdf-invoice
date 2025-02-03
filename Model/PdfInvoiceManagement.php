<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Model;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception as WebApiException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Ytec\RestPdfInvoice\Api\PdfInvoiceManagementInterface;
use Ytec\RestPdfInvoice\Util\Config as ModuleConfig;
use Ytec\RestPdfInvoice\Service\RestInvoicePdfGeneratorService;

/**
 * Class to manage the PDF invoice generation and response.
 */
class PdfInvoiceManagement implements PdfInvoiceManagementInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var RestInvoicePdfGeneratorService
     */
    private RestInvoicePdfGeneratorService $pdfGeneratorService;

    /**
     * @var ModuleConfig
     */
    private ModuleConfig $moduleConfig;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $responseInterface;

    /**
     * Constructor.
     *
     * @param RestInvoicePdfGeneratorService $pdfGeneratorService
     * @param OrderRepositoryInterface $orderRepository
     * @param ModuleConfig $moduleConfig
     * @param ResponseInterface $responseInterface
     */
    public function __construct(
        RestInvoicePdfGeneratorService $pdfGeneratorService,
        OrderRepositoryInterface $orderRepository,
        ModuleConfig $moduleConfig,
        ResponseInterface $responseInterface
    ) {
        $this->orderRepository = $orderRepository;
        $this->pdfGeneratorService = $pdfGeneratorService;
        $this->moduleConfig = $moduleConfig;
        $this->responseInterface = $responseInterface;
    }

    /**
     * Return an invoice PDF response based on given orderId in the endpoint.
     *
     * @inheritDoc
     * @throws NoSuchEntityException|\Zend_Pdf_Exception
     * @throws \Exception
     */
    public function getByOrderId(int $orderId): ResponseInterface
    {
        if ($this->moduleConfig->isDisabled()) {
            throw new WebApiException(__('The functionality is currently disabled.'));
        }

        $order = $this->loadOrder($orderId);
        $invoices = $order->getInvoiceCollection();

        if ($invoices->getSize() === 0) {
            throw new NoSuchEntityException(__('No invoices found for order with ID "%1".', $orderId));
        }

        $pdfContent = $this->pdfGeneratorService->generate($invoices)->render();

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $this->responseInterface
            ->setHeader('Content-Type', 'application/pdf', true)
            ->setHeader('Content-Disposition', 'attachment; filename="invoice.pdf"', true)
            ->setHeader('Content-Length', strlen($pdfContent), true)
            ->setBody($pdfContent)
        ->sendResponse();

        return $this->responseInterface;
    }

    /**
     * Loads the order based on the orderId given in the request.
     *
     * @param int $orderId
     * @return OrderInterface
     * @throws InputException
     * @throws NoSuchEntityException
     */
    private function loadOrder(int $orderId): OrderInterface
    {
        if (!$orderId) {
            throw InputException::requiredField('orderId');
        }

        try {
            return $this->orderRepository->get($orderId);
        } catch (NoSuchEntityException $ex) {
            throw new NoSuchEntityException(__('No order found with ID "%1".', $orderId));
        }
    }
}
