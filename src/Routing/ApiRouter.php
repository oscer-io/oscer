<?php

namespace Bambamboole\LaravelCms\Routing;

use Bambamboole\LaravelCms\Auth\Http\Middleware\Authenticate;
use Bambamboole\LaravelCms\Publishing\Http\Controllers\Api\PagesController;
use Illuminate\Routing\Router;

class ApiRouter
{
    protected Router $router;

    protected string $prefix = 'cms/api';

    protected array $middleware = [Authenticate::class];

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
                $router->get('/pages', [PagesController::class, 'index'])->name('pages.index');
                $router->get('/pages/{id}', [PagesController::class, 'show'])->name('pages.index');
            });
    }
}
