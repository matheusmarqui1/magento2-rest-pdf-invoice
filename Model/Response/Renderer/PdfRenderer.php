<?php

namespace Ytec\RestPdfInvoice\Model\Response\Renderer;

use Magento\Framework\Webapi\Exception as WebApiException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Webapi\Rest\Response\RendererInterface;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Ytec\RestPdfInvoice\Service\RestInvoicePdfGeneratorService;

class PdfRenderer implements RendererInterface
{
    public const MIME_TYPE = 'application/pdf';

    private Request $request;
    private RestInvoicePdfGeneratorService $invoicePdfGeneratorService;
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(
        Request $request,
        RestInvoicePdfGeneratorService $invoicePdfGeneratorService,
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->request = $request;
        $this->invoicePdfGeneratorService = $invoicePdfGeneratorService;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @inheritDoc
     * @throws WebApiException
     * @throws \Zend_Pdf_Exception
     */
    public function render($data): ?string
    {
        if (!str_contains($this->request->getPathInfo(), '/V1/invoices')) {
            throw new WebApiException(__('PDF is not allowed for the provided endpoint.'));
        }

        if (isset($data['entity_id'])) {
            $invoice = $this->invoiceRepository->get($data['entity_id']);
            $pdf = $this->invoicePdfGeneratorService->generate([$invoice]);

            return $pdf->render();
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getMimeType(): string
    {
        return self::MIME_TYPE;
    }
}
