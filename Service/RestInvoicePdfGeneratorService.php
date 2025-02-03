<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Service;

use Magento\Sales\Model\Order\Pdf\Invoice as InvoicePdf;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Model\ResourceModel\Order\Invoice\Collection as InvoiceCollection;

/**
 * Service to generate PDF invoices.
 */
class RestInvoicePdfGeneratorService
{
    /**
     * @var InvoicePdf
     */
    private InvoicePdf $invoicePdf;

    /**
     * @param InvoicePdf $invoicePdf
     */
    public function __construct(InvoicePdf $invoicePdf)
    {
        $this->invoicePdf = $invoicePdf;
    }

    /**
     * Generates a pdf based on given invoices.
     *
     * @param array<InvoiceInterface>|InvoiceCollection $invoices
     * @return \Zend_Pdf
     */
    public function generate($invoices): \Zend_Pdf
    {
        return $this->invoicePdf->getPdf($invoices);
    }
}
