# Installation

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
