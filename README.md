# A small CMS/Blog as a Laravel package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bambamboole/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/bambamboole/laravel-cms)
[![StyleCI](https://github.styleci.io/repos/244145339/shield?branch=master)](https://github.styleci.io/repos/244145339)
[![Build Status](https://img.shields.io/travis/bambamboole/laravel-cms/master.svg?style=flat-square)](https://travis-ci.org/bambamboole/laravel-cms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bambamboole/laravel-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bambamboole/laravel-cms/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/bambamboole/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/bambamboole/laravel-cms)

## Pre Alpha State !!!
The vision behind this package is to build a developer friendly CMS and blogging system. 

## Installation

### Install dependencies
You can install the package via composer:
```bash
composer require bambamboole/laravel-cms
```

### Add additional database connection
Laravel CMS uses an additional database connection. We do this to ensure that the intrusion into existing Laravel 
applications is as small as possible. The connection needs to be added to the `connections` key 
inside your `config/databases.php`. Simply copy the `mysql` entry and rename it to `cms`. Additionally you may prefix 
all used environment variables with `CMS_`. The result may look like this:

```php
        'cms' => [
            'driver' => 'mysql',
            'url' => env('CMS_DATABASE_URL'),
            'host' => env('CMS_DB_HOST', '127.0.0.1'),
            'port' => env('CMS_DB_PORT', '3306'),
            'database' => env('CMS_DB_DATABASE', 'forge'),
            'username' => env('CMS_DB_USERNAME', 'forge'),
            'password' => env('CMS_DB_PASSWORD', ''),
            'unix_socket' => env('CMS_DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
```

Now add the new environment variables to your `.env` file and fill them with correct credentials for the new database:
```
CMS_DB_HOST=127.0.0.1
CMS_DB_PORT=3306
CMS_DB_DATABASE=cms
CMS_DB_USERNAME=user
CMS_DB_PASSWORD=secret
``` 

### Enabling pages and posts routes
Create a new `CmsServiceProvider` with the following `boot()` call:
```php
<?php

namespace App\Providers;

use Bambamboole\LaravelCms\Services\CmsRouter;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot(CmsRouter $router)
    {
        $router->registerPagesRoutes();
        $router->registerPostsRoutes();
    }
}
```  
Do not forget to register it in the `providers` key inside your `config/app.php`.

### Publish config and migrate database

```bash
php artisan cms:publish
php artisan cms:migrate
```  
If you migrate the first time, it will also create a user and show the credentials in the console.

## Usage
Head to the `/admin/login` route and use the credentials from the first migration.

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
