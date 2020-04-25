# Installation

### Install dependencies
You can install the package via composer:
```bash
composer require oscer-io/oscer
```

### Run migrations
Oscer adds its migrations to the default Laravel database connection. 
We prefix all tables with `cms_` to ensure they are not clashing with your migrations.
```bash
php artisan migrate
```

### Enabling pages and posts routes
Create a new `CmsServiceProvider` with the following `boot()` call:
```php
<?php

namespace App\Providers;

use Oscer\Cms\Frontend\Routing\FrontendRouter;
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

### Publish config

```bash
php artisan cms:publish
```  

### Add environment variable

Let the authentication system know on which domain Oscer will run:
```bash
# ...
CMS_BACKEND_DOMAIN=web.cms.test
```  

