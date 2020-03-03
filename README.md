# A small CMS/Blog as a Laravel package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bambamboole/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/bambamboole/laravel-cms)
[![StyleCI](https://github.styleci.io/repos/244145339/shield?branch=master)](https://github.styleci.io/repos/244145339)
[![Build Status](https://img.shields.io/travis/bambamboole/laravel-cms/master.svg?style=flat-square)](https://travis-ci.org/bambamboole/laravel-cms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bambamboole/laravel-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bambamboole/laravel-cms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/bambamboole/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/bambamboole/laravel-cms)

## !!! THIS is not usable yet. Development just startet !!!
The vision behind this package is to build a developer friendly CMS and blogging system. 
We are currently planning the milestones for the road map.

## Installation

You can install the package via composer:

```bash
composer require bambamboole/laravel-cms
```

## Usage

``` php
* `php artisan cms:publish` -> publishes the config and the assets
* `php artisan cms:migrate` -> Runs all migrations on the configuren database connection
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email manuel@christlieb.eu instead of using the issue tracker.

## Credits

- [Manuel Christlieb](https://github.com/bambamboole)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
