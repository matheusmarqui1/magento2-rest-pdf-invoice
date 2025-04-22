<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Model\Order\Pdf;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Payment\Helper\Data;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Sales\Model\Order\Pdf\Config;
use Magento\Sales\Model\Order\Pdf\Invoice as BaseMagentoInvoice;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Pdf\Total\Factory as TotalFactory;
use Magento\Sales\Model\Order\Pdf\ItemsFactory;
use Ytec\RestPdfInvoice\Util\Config as ModuleConfig;

/**
 * Custom PDF invoice class that extends the base Magento invoice class
 * The modifications are made to reduce the invoice PDF size and improve the performance
 * of the API.
 */
class Invoice extends BaseMagentoInvoice
{
    /**
     * @var ModuleConfig
     */
    private ModuleConfig $moduleConfig;

    /**
     * Invoice constructor.
     *
     * @param Data $paymentData
     * @param StringUtils $string
     * @param ScopeConfigInterface $scopeConfig
     * @param Filesystem $filesystem
     * @param Config $pdfConfig
     * @param TotalFactory $pdfTotalFactory
     * @param ItemsFactory $pdfItemsFactory
     * @param TimezoneInterface $localeDate
     * @param StateInterface $inlineTranslation
     * @param Renderer $addressRenderer
     * @param StoreManagerInterface $storeManager
     * @param Emulation $appEmulation
     * @param ModuleConfig $moduleConfig
     * @param array $data
     */
    public function __construct(
        Data                  $paymentData,
        StringUtils           $string,
        ScopeConfigInterface  $scopeConfig,
        Filesystem            $filesystem,
        Config                $pdfConfig,
        TotalFactory          $pdfTotalFactory,
        ItemsFactory          $pdfItemsFactory,
        TimezoneInterface     $localeDate,
        StateInterface        $inlineTranslation,
        Renderer              $addressRenderer,
        StoreManagerInterface $storeManager,
        Emulation             $appEmulation,
        ModuleConfig          $moduleConfig,
        array                 $data = []
    ) {
        parent::__construct(
            $paymentData,
            $string,
            $scopeConfig,
            $filesystem,
            $pdfConfig,
            $pdfTotalFactory,
            $pdfItemsFactory,
            $localeDate,
            $inlineTranslation,
            $addressRenderer,
            $storeManager,
            $appEmulation,
            $data
        );

        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @inheirtDoc
     */
    protected function _setFontRegular($object, $size = 7): \Zend_Pdf_Resource_Font
    {
        if (!$this->moduleConfig->isPdfSizeReductionEnabled()) {
            return parent::_setFontRegular($object, $size);
        }

        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA);
        $object->setFont($font, $size);

        return $font;
    }

    /**
     * @inheirtDoc
     */
    protected function _setFontBold($object, $size = 7): \Zend_Pdf_Resource_Font
    {
        if (!$this->moduleConfig->isPdfSizeReductionEnabled()) {
            return parent::_setFontBold($object, $size);
        }

        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $object->setFont($font, $size);

        return $font;
    }

    /**
     * @inheirtDoc
     */
    protected function _setFontItalic($object, $size = 7): \Zend_Pdf_Resource_Font
    {
        if (!$this->moduleConfig->isPdfSizeReductionEnabled()) {
            return parent::_setFontItalic($object, $size);
        }

        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA_ITALIC);
        $object->setFont($font, $size);

        return $font;
    }
}
