<?php

namespace Bambamboole\LaravelCms;

use Bambamboole\LaravelCms\Commands\Development\SeedCommand;
use Bambamboole\LaravelCms\Commands\MigrateCommand;
use Bambamboole\LaravelCms\Commands\PublishCommand;
use Bambamboole\LaravelCms\Models\User;
use Bambamboole\LaravelCms\Services\CmsRouter;
use Illuminate\Support\ServiceProvider;

class LaravelCmsServiceProvider extends ServiceProvider
{
    public function boot(CmsRouter $router)
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        $this->registerGuard();
        $this->registerPublishes();

        $router->registerBackendRoutes();
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
    }
}
