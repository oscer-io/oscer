# Installation

### Install dependencies
You can install the package via composer:
```bash
composer require bambamboole/laravel-cms
```

### Run migrations
Laravel CMS adds its migrations to the default Laravel database connection. 
We prefix all tables with `cms_` to ensure they are not clashing with your migrations.


### Enabling pages and posts routes
Create a new `CmsServiceProvider` with the following `boot()` call:
```php
<?php

namespace App\Providers;

use Bambamboole\LaravelCms\Routing\FrontendRouter;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot(FrontendRouter $router)
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
php artisan migrate
```  
If you migrate the first time, it will also create a user and show the credentials in the console.
