<?php

namespace Oscer\Cms\Api;

use Illuminate\Support\ServiceProvider;
use Oscer\Cms\Api\Routing\ApiRouter;

class ApiServiceProvider extends ServiceProvider
{
    public function boot(ApiRouter $router)
    {
        $router->registerApiRoutes();
    }
}
