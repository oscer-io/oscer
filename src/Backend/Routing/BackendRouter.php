<?php

namespace Bambamboole\LaravelCms\Backend\Routing;

use Bambamboole\LaravelCms\Backend\Http\Controllers\Auth\ForgotPasswordController;
use Bambamboole\LaravelCms\Backend\Http\Controllers\Auth\LoginController;
use Bambamboole\LaravelCms\Backend\Http\Controllers\BackendController;
use Bambamboole\LaravelCms\Backend\Http\Controllers\ResourceFormController;
use Bambamboole\LaravelCms\Core\Http\Middleware\Authenticate;
use Bambamboole\LaravelCms\Core\Http\Middleware\SetLocale;
use Illuminate\Config\Repository;
use Illuminate\Routing\Router;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class BackendRouter
{
    protected Router $router;

    protected Repository $config;

    public function __construct(Router $router, Repository $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    public function registerAuthRoutes()
    {
        $this->router
            ->middleware([$this->config->get('cms.backend.middleware'), SetLocale::class])
            ->as('cms.')
            ->prefix($this->config->get('cms.backend.url'))
            ->group(function (Router $router) {
                $router->get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
                $router->post('/login', [LoginController::class, 'login'])->name('auth.attempt');
                $router->get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

                $router->get('/password/forgot', [ForgotPasswordController::class, 'showResetRequestForm'])->name('password.forgot');
                $router->post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
                $router->get('/password/reset/{token}', [ForgotPasswordController::class, 'showNewPassword'])->name('password.reset');
            });
    }

    public function registerBackendRoutes(): void
    {
        $this->router
            ->middleware([
                $this->config->get('cms.backend.middleware'),
                Authenticate::class,
                SetLocale::class,
            ])
            ->as('cms.backend.')
            ->prefix($this->config->get('cms.backend.url'))
            ->group(function (Router $router) {
                $router->get('/', [BackendController::class, 'show'])->name('start');
                $router->get('/forms/{resource}/{id?}', [ResourceFormController::class, 'show'])->name('forms.show');
                $router->post('/forms/{resource}/{id?}', [ResourceFormController::class, 'store'])->name('forms.store');
                $router->get('/{view}', [BackendController::class, 'show'])
                    ->where('view', '.*')->name('router');
            });
        $this->router->aliasMiddleware('permission', PermissionMiddleware::class);
    }
}
