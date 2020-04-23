<?php

namespace Oscer\Cms\Api\Routing;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Oscer\Cms\Api\Http\Controllers\IssueTokenController;
use Oscer\Cms\Api\Http\Controllers\MenuOrderController;
use Oscer\Cms\Core\Http\Middleware\Authenticate;

class ApiRouter
{
    protected Router $router;

    protected string $prefix = 'api/cms/';

    protected array $middleware = [
        'throttle:60,1',
        SubstituteBindings::class,
    ];

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function registerApiRoutes()
    {
        $this->router
            ->middleware($this->middleware)
            ->as('cms.api.')
            ->prefix($this->prefix)
            ->group(function (Router $router) {
                $router->post('/auth/token', IssueTokenController::class)->name('auth.token');
            });

        $this->registerProtectedApiRoutes();
    }

    protected function registerProtectedApiRoutes()
    {
        $this->router
            ->middleware([EnsureFrontendRequestsAreStateful::class, ...$this->middleware, Authenticate::class])
            ->as('cms.api.')
            ->prefix($this->prefix)
            ->group(function (Router $router) {
                $router->post('/menus/{name}/save_order', [MenuOrderController::class, 'update'])->name('menus.save_order');
            });
    }
}
