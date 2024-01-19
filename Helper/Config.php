<?php

namespace Ytec\RestPdfInvoice\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
    * XML path for the enabled setting.
    */
    public const XML_PATH_ENABLED = 'ytec_rest_pdf_invoice/general/enable';

    private ScopeConfigInterface $scopeConfig;
    private StoreManagerInterface $storeManager;

    /**
     * Constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(ScopeConfigInterface $scopeConfig, StoreManagerInterface $storeManager)
    {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Checks if the Rest Pdf Invoice functionality is enabled.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }

    /**
     * Checks if the Rest Pdf Invoice functionality is disabled.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }
}
