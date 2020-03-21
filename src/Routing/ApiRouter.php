<?php

namespace Bambamboole\LaravelCms\Routing;

use Bambamboole\LaravelCms\Auth\Http\Controllers\Api\IssueTokenController;
use Bambamboole\LaravelCms\Core\Http\Controllers\SwaggerUiController;
use Bambamboole\LaravelCms\Publishing\Http\Controllers\Api\PagesController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;

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
            ->middleware([...$this->middleware, 'auth:sanctum'])
            ->as('cms.api.')
            ->prefix($this->prefix)
            ->group(function (Router $router) {
                $router->get('/pages', [PagesController::class, 'index'])->name('pages.index');
                $router->get('/pages/{id}', [PagesController::class, 'show'])->name('pages.index');
            });
    }

    public function withSwaggerUi()
    {
        $this->router
            ->middleware('web')
            ->as('cms.api.')
            ->prefix($this->prefix)
            ->group(function (Router $router) {
                $router->get('/swagger-ui', SwaggerUiController::class)->name('swagger-ui');
            });
    }
}
