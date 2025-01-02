# TipRanks API integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nikosid/tipranks.svg?style=flat-square)](https://packagist.org/packages/nikosid/tipranks)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/nikosid/tipranks/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nikosid/tipranks/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/nikosid/tipranks/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/nikosid/tipranks/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/nikosid/tipranks.svg?style=flat-square)](https://packagist.org/packages/nikosid/tipranks)

This package provides a Laravel integration for the TipRanks API, allowing you to easily interact with various endpoints provided by TipRanks.

## Inspiration

This component was inspired by [visuxls/tipranks](https://github.com/visuxls/tipranks).

## Installation

You can install the package via composer:

```bash
composer require nikosid/tipranks
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="tipranks-config"
```

Next, add the following environment variables to your .env file:

```bash
TIPRANKS_EMAIL=your_email@example.com
TIPRANKS_PASSWORD=your_password
```

## Usage

```php
use Nikosid\Tipranks\Tipranks;

$tipranks = app(Tipranks::class);
$topAnalystStocks = $tipranks->getTopAnalystStocks();
print_r($topAnalystStocks);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Yurii Chernichenko](https://github.com/nikosid)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
