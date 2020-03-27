<?php

namespace Bambamboole\LaravelCms\Routing;

use Bambamboole\LaravelCms\Auth\Http\Controllers\ForgotPasswordController;
use Bambamboole\LaravelCms\Auth\Http\Controllers\LoginController;
use Bambamboole\LaravelCms\Auth\Http\Middleware\Authenticate;
use Bambamboole\LaravelCms\Core\Http\Controllers\BackendController;
use Bambamboole\LaravelCms\Core\Http\Middleware\SetInertiaConfiguration;
use Bambamboole\LaravelCms\Core\Http\Middleware\SetLocale;
use Bambamboole\LaravelCms\Menus\Http\Controllers\MenusController;
use Bambamboole\LaravelCms\Options\Http\Controllers\OptionsController;
use Bambamboole\LaravelCms\Publishing\Http\Controllers\PagesController;
use Bambamboole\LaravelCms\Publishing\Http\Controllers\PostsController;
use Bambamboole\LaravelCms\Users\Http\Controllers\ProfileController;
use Bambamboole\LaravelCms\Users\Http\Controllers\UsersController;
use Illuminate\Config\Repository;
use Illuminate\Routing\Router;

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
        $this->router->middleware([$this->config->get('cms.backend.middleware'), SetLocale::class])
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
                SetInertiaConfiguration::class,
                SetLocale::class,
            ])
            ->as('cms.backend.')
            ->prefix($this->config->get('cms.backend.url'))
            ->group(function (Router $router) {
                $router->get('/', [BackendController::class, 'show'])->name('start');
                $router->get('/{view}', [BackendController::class, 'show'])
                    ->where('view', '.*')->name('router');
            });
    }
}
