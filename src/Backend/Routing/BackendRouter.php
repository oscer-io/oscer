<?php

namespace Oscer\Cms\Backend\Routing;

use Illuminate\Config\Repository;
use Illuminate\Routing\Router;
use Oscer\Cms\Backend\Http\Controllers\Auth\ForgotPasswordController;
use Oscer\Cms\Backend\Http\Controllers\Auth\LoginController;
use Oscer\Cms\Backend\Http\Controllers\Auth\ResetPasswordController;
use Oscer\Cms\Backend\Http\Controllers\BackendController;
use Oscer\Cms\Backend\Http\Controllers\ResourceCreateController;
use Oscer\Cms\Backend\Http\Controllers\ResourceDeleteController;
use Oscer\Cms\Backend\Http\Controllers\ResourceIndexController;
use Oscer\Cms\Backend\Http\Controllers\ResourceShowController;
use Oscer\Cms\Backend\Http\Controllers\ResourceStoreController;
use Oscer\Cms\Core\Http\Middleware\Authenticate;
use Oscer\Cms\Core\Http\Middleware\SetLocale;
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
                $router->get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
                $router->post('/password/reset', [ResetPasswordController::class, 'update'])->name('password.update');
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
                $router->get('/resources/{resource}', [ResourceIndexController::class, 'handle'])->name('resources.index');
                $router->get('/resources/{resource}/create', [ResourceCreateController::class, 'handle'])->name('resources.create');
                $router->get('/resources/{resource}/{id}', [ResourceShowController::class, 'handle'])->name('resources.show');
                $router->delete('/resources/{resource}/{id}', [ResourceDeleteController::class, 'handle'])->name('resources.delete');
                $router->post('/resources/{resource}/{id?}', [ResourceStoreController::class, 'handle'])->name('resources.store');
                $router->get('/{view}', [BackendController::class, 'show'])
                    ->where('view', '.*')->name('router');
            });
        $this->router->aliasMiddleware('permission', PermissionMiddleware::class);
    }
}
