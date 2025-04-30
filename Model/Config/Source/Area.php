<?php
/**
 * Copyright (c) 2025 Ytec.
 *
 * @package    Ytec
 * @moduleName RestPdfInvoice
 * @author     Matheus Marqui <matheus.701@live.com>
 */
declare(strict_types=1);

namespace Ytec\RestPdfInvoice\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Area as AppArea;

/**
 * Class Area
 *
 * Represents the area configuration source for the PDF invoice reduction feature.
 */
class Area implements OptionSourceInterface
{
    /**
     * @var array
     */
    private array $options = [];

    /**
     * Get options for the area.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if (empty($this->options)) {
            $this->options = [
                [
                    'label' => __('Frontend'),
                    'value' => AppArea::AREA_FRONTEND,
                ],
                [
                    'label' => __('Adminhtml'),
                    'value' => AppArea::AREA_ADMINHTML,
                ],
                [
                    'label' => __('Webapi Rest'),
                    'value' => AppArea::AREA_WEBAPI_REST,
                ],
                [
                    'label' => __('Webapi Soap'),
                    'value' => AppArea::AREA_WEBAPI_SOAP,
                ],
                [
                    'label' => __('GraphQl'),
                    'value' => AppArea::AREA_GRAPHQL,
                ]
            ];
        }

        return $this->options;
    }
}
