<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Api;

use Magento\Framework\App\ResponseInterface;

interface PdfInvoiceManagementInterface
{
    /**
     * Get the PDF invoice by order ID.
     *
     * @param string $orderId Order's ID (Entity ID or Increment ID).
     * @return ResponseInterface
     */
    public function getByOrderId(string $orderId): \Magento\Framework\App\ResponseInterface;
}
