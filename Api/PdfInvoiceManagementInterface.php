<?php

namespace Ytec\RestPdfInvoice\Api;

interface PdfInvoiceManagementInterface
{
    /**
     * @param int $orderId
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function getByOrderId(int $orderId): \Magento\Framework\App\ResponseInterface;
}
