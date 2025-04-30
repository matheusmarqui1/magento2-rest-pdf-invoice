<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Util;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Utility class for module configurations.
 */
class Config
{
    /**
     * XML path for the enabled setting.
     */
    public const XML_PATH_ENABLED = 'ytec_rest_pdf_invoice/general/enable';

    /**
     * XML path for the PDF size reduction setting.
     */
    public const XML_PATH_PDF_SIZE_REDUCTION_ENABLED = 'ytec_rest_pdf_invoice/general/reduce_pdf_size_enabled';

    /**
     * XML path for the PDF size reduction areas.
     */
    public const XML_PATH_PDF_SIZE_REDUCTION_AREAS = 'ytec_rest_pdf_invoice/general/apply_pdf_size_reduction_on_areas';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * Constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Checks if the Rest PDF Invoice functionality is enabled.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * Checks if the Rest PDF Invoice functionality is disabled.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }

    /**
     * Checks if the PDF size reduction is enabled.
     *
     * @return bool
     */
    public function isPdfSizeReductionEnabled(): bool
    {
        try {
            $scopeCode = $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $exception) {
            $scopeCode = null;
        }

        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_PDF_SIZE_REDUCTION_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Retrieves the areas where PDF size reduction is enabled.
     *
     * @return array
     */
    public function getPdfReductionEnabledAreas(): array
    {
        try {
            $rawAreaList = $this->scopeConfig->getValue(
                static::XML_PATH_PDF_SIZE_REDUCTION_AREAS,
                ScopeInterface::SCOPE_STORE,
                $this->storeManager->getStore()->getId()
            );
        } catch (NoSuchEntityException $exception) {
            return [];
        }

        if (empty($rawAreaList)) {
            return [];
        }

        return explode(',', $rawAreaList);
    }
}
