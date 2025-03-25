<div align="center">

![Ytec Rest Pdf Invoice for Magento 2](https://i.imgur.com/d8QEHRb.png)
# Ytec Rest Pdf Invoice for Magento 2

</div>

<div align="center">

[![Packagist Version](https://img.shields.io/packagist/v/ytec/rest-pdf-invoice?logo=packagist&style=for-the-badge)](https://packagist.org/packages/ytec/rest-pdf-invoice)
[![Packagist Downloads](https://img.shields.io/packagist/dt/ytec/rest-pdf-invoice.svg?logo=composer&style=for-the-badge)](https://packagist.org/packages/ytec/rest-pdf-invoice/stats)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.4.x-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
![License](https://img.shields.io/badge/license-MIT-green?color=%23234&style=for-the-badge)

</div>

## Introduction

Introducing Ytec Rest Pdf Invoice for Magento 2: a streamlined module that simplifies retrieving PDF invoices via REST API endpoints, doing exacly what it says. 😎

## Features

- **GET /rest/V1/orders/:orderId/pdf-invoice Endpoint**: Retrieve a PDF invoice for a specific order.
- **Modified GET /rest/V1/invoices/:invoiceId Endpoint**: Now renders a PDF invoice when requested with an 'Accept: application/pdf' header.

## Prerequisites

- PHP 7.4 or higher
- Magento 2.4.x

## Installation

1. Run `composer require ytec/rest-pdf-invoice` in your Magento root directory.
2. Execute `bin/magento setup:upgrade`.
3. Clear the cache by running `bin/magento cache:clean` and `bin/magento cache:flush`.

## How to Use

### Retrieving a PDF Invoice for an Order

Send a GET request to `/rest/V1/orders/:orderId/pdf-invoice` with appropriate authorization. Replace `:orderId` with the actual order ID (entity_id or increment_id are supported).

### Retrieving a PDF Invoice for an Invoice

Send a GET request to `/rest/V1/invoices/:invoiceId` with the header `Accept: application/pdf` and appropriate authorization. Replace `:invoiceId` with the actual invoice ID.

## Dependencies

This module depends on the following Magento 2 modules:

- `Magento_Sales`
- `Magento_Framework`

## License

This module is open-source but all credits belong to Ytec, a company of Matheus da Costa Marqui. For the full license, please refer to the LICENSE.md file.

## Support and Contribution

For bugs, issues or feature requests, please open an issue on the repository or send an email to matheus.701@live.com for more personalized assistance.

---

Copyright (c) 2023 Ytec, a company of Matheus da Costa Marqui (matheus.701@live.com)
