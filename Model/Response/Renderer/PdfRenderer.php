<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Model\Response\Renderer;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception as WebApiException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Webapi\Rest\Response\RendererInterface;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Ytec\RestPdfInvoice\Service\RestInvoicePdfGeneratorService;
use Ytec\RestPdfInvoice\Util\Config as ModuleConfig;

/**
 * Custom renderer to generate PDF invoices.
 */
class PdfRenderer implements RendererInterface
{
    /**
     * The MIME type for PDF files.
     */
    public const MIME_TYPE = 'application/pdf';

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var RestInvoicePdfGeneratorService
     */
    private RestInvoicePdfGeneratorService $invoicePdfGeneratorService;

    /**
     * @var InvoiceRepositoryInterface
     */
    private InvoiceRepositoryInterface $invoiceRepository;

    /**
     * @var ModuleConfig
     */
    private ModuleConfig $moduleConfig;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param RestInvoicePdfGeneratorService $invoicePdfGeneratorService
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param ModuleConfig $moduleConfig
     */
    public function __construct(
        Request $request,
        RestInvoicePdfGeneratorService $invoicePdfGeneratorService,
        InvoiceRepositoryInterface $invoiceRepository,
        ModuleConfig $moduleConfig
    ) {
        $this->request = $request;
        $this->invoicePdfGeneratorService = $invoicePdfGeneratorService;
        $this->invoiceRepository = $invoiceRepository;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @inheritDoc
     * @throws WebApiException
     * @throws \Zend_Pdf_Exception
     * @throws NoSuchEntityException
     */
    public function render($data): ?string
    {
        if ($this->moduleConfig->isDisabled()) {
            throw new WebApiException(__('The functionality is currently disabled.'));
        }

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
