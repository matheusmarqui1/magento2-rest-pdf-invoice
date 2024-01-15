<?php

namespace Ytec\RestPdfInvoice\Model;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Ytec\RestPdfInvoice\Api\PdfInvoiceManagementInterface;
use Ytec\RestPdfInvoice\Service\RestInvoicePdfGeneratorService;
use Ytec\RestPdfInvoice\Service\RestPdfFileService;

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
     * @var RestPdfFileService
     */
    private RestPdfFileService $restPdfFileService;

    /**
     * @param RestInvoicePdfGeneratorService $pdfGeneratorService
     * @param RestPdfFileService $restPdfFileService
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        RestInvoicePdfGeneratorService $pdfGeneratorService,
        RestPdfFileService $restPdfFileService,
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
        $this->pdfGeneratorService = $pdfGeneratorService;
        $this->restPdfFileService = $restPdfFileService;
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
        $order = $this->loadOrder($orderId);
        $invoices = $order->getInvoiceCollection();

        if ($invoices->getSize() === 0) {
            throw new NoSuchEntityException(__('No invoices found for order with ID "%1".', $orderId));
        }

        $pdfContent = $this->pdfGeneratorService->generate($invoices)->render();

        return $this->restPdfFileService->getResponse($pdfContent);
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
