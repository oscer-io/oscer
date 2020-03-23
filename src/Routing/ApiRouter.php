<?php

namespace Bambamboole\LaravelCms\Routing;

use Bambamboole\LaravelCms\Auth\Http\Controllers\Api\IssueTokenController;
use Bambamboole\LaravelCms\Core\Http\Controllers\OpenApiController;
use Bambamboole\LaravelCms\Core\Http\Controllers\SwaggerUiController;
use Bambamboole\LaravelCms\Publishing\Http\Controllers\Api\PagesController;
use Bambamboole\LaravelCms\Users\Http\Controllers\Api\ProfileAvatarController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class ApiRouter
{
    protected Router $router;

    protected string $prefix = 'api/cms/';

    protected array $middleware = [
        EnsureFrontendRequestsAreStateful::class,
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
                $router->get('/swagger-ui', SwaggerUiController::class)->name('swagger-ui');
                $router->get('/open-api/reference/definition.yaml', [OpenApiController::class, 'reference'])->name('oas.reference');
                $router->get('/open-api/{folder}/{file}', [OpenApiController::class, 'file'])->name('oas.file');
                $router->post('/profile/avatar', [ProfileAvatarController::class, 'update'])->name('profile.avatar');
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
                $router->post('/pages', [PagesController::class, 'store'])->name('pages.store');
                $router->get('/pages/{id}', [PagesController::class, 'show'])->name('pages.index');
                $router->patch('/pages/{id}', [PagesController::class, 'update'])->name('pages.update');
                $router->delete('/pages/{id}', [PagesController::class, 'delete'])->name('pages.delete');
            });
    }
}
