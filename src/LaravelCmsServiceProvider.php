<?php

namespace Bambamboole\LaravelCms;

use Bambamboole\LaravelCms\Commands\Development\SeedCommand;
use Bambamboole\LaravelCms\Commands\MigrateCommand;
use Bambamboole\LaravelCms\Commands\PublishCommand;
use Bambamboole\LaravelCms\Http\Controllers\Auth\ForgotPasswordController;
use Bambamboole\LaravelCms\Http\Controllers\Auth\LoginController;
use Bambamboole\LaravelCms\Http\Middleware\Authenticate;
use Bambamboole\LaravelCms\Http\Middleware\SetInertiaConfiguration;
use Bambamboole\LaravelCms\Http\Middleware\SetLocale;
use Bambamboole\LaravelCms\Http\ViewComposers\ThemeViewComposer;
use Bambamboole\LaravelCms\Models\User;
use Bambamboole\LaravelCms\Themes\DefaultTheme;
use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;

class LaravelCmsServiceProvider extends ServiceProvider
{

    public function boot(Factory $view, Theme $theme)
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        $this->registerGuard();
        $this->registerRoutes();
        $this->registerPublishes();

        $view->composer([
            $theme->getBlogIndexTemplate(),
            $theme->getBlogPostTemplate(),
            $theme->getPageTemplate(),
        ], ThemeViewComposer::class);
    }

    /**
     * Register the package's guard.
     */
    protected function registerGuard(): void
    {
        $this->app['config']->set('auth.providers.cms_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $this->app['config']->set('auth.guards.cms', [
            'driver' => 'session',
            'provider' => 'cms_users',
        ]);
    }

    protected function registerRoutes(): void
    {
        $middleware = config('cms.backend.middleware', 'web');
        $urlPrefix = config('cms.backend.url', 'admin');

        Route::middleware([$middleware, SetLocale::class])
            ->as('cms.')
            ->prefix($urlPrefix)
            ->group(function () {
                Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
                Route::post('/login', [LoginController::class, 'login'])->name('auth.attempt');
                Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

                Route::get('/password/forgot', [ForgotPasswordController::class, 'showResetRequestForm'])->name('password.forgot');
                Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
                Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showNewPassword'])->name('password.reset');
            });

        Route::middleware([$middleware, Authenticate::class, SetInertiaConfiguration::class, SetLocale::class])
            ->as('cms.')
            ->prefix($urlPrefix)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
            });
    }

    protected function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../dist' => public_path('vendor/cms'),
            ], 'cms-assets');

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('cms.php'),
            ], 'cms-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'cms');

        $this->commands([
            PublishCommand::class,
            MigrateCommand::class,
            SeedCommand::class,
        ]);

        $this->app->bind(Theme::class, function (){
            return new DefaultTheme();
        });
    }
}
