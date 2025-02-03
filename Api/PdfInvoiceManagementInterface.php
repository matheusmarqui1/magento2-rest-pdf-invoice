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

interface PdfInvoiceManagementInterface
{
    /**
     * Get the PDF invoice by order ID.
     *
     * @param int $orderId
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function getByOrderId(int $orderId): \Magento\Framework\App\ResponseInterface;
}
