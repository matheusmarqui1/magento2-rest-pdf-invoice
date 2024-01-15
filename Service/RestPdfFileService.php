<?php

namespace Ytec\RestPdfInvoice\Service;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Response\Http\FileFactory;

class RestPdfFileService
{
    private FileFactory $fileFactory;

    public function __construct(FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }

    /**
     * @throws \Exception
     */
    public function getResponse(string $pdfContent): ResponseInterface
    {
        return $this->fileFactory->create(
            $this->getFileName(),
            $pdfContent,
            \Magento\Framework\App\Filesystem\DirectoryList::TMP,
            \Ytec\RestPdfInvoice\Model\Response\Renderer\PdfRenderer::MIME_TYPE
        );
    }

    private function getFileName(): string
    {
        return sprintf('invoice_generated_%s.pdf', date('Y-m-d_H-i-s'));
    }
}
