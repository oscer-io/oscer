<?php

namespace Bambamboole\LaravelCms;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Core\Commands\Development\SeedCommand;
use Bambamboole\LaravelCms\Core\Commands\PublishCommand;
use Bambamboole\LaravelCms\Routing\ApiRouter;
use Bambamboole\LaravelCms\Routing\BackendRouter;
use Bambamboole\LaravelCms\Theming\BladeComponents\MenuBladeComponent;
use Bambamboole\LaravelCms\Theming\Contracts\Theme;
use Bambamboole\LaravelCms\Theming\DefaultTheme;
use Bambamboole\LaravelCms\Theming\ViewComposers\ThemeViewComposer;
use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;

class LaravelCmsServiceProvider extends ServiceProvider
{
    public function boot(
        ApiRouter $apiRouter,
        BackendRouter $backendRouter,
        BladeCompiler $blade,
        Repository $config,
        Factory $view,
        Theme $theme
    )
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cms');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
        $this->registerGuard();
        $this->registerPublishes();

        $apiRouter->registerApiRoutes();

        $backendRouter->registerAuthRoutes();
        $backendRouter->registerBackendRoutes();

        $view->composer([
            $theme->getPostShowTemplate(),
            $theme->getPageTemplate(),
            $theme->getPostIndexTemplate(),
        ], ThemeViewComposer::class);

        $blade->component(MenuBladeComponent::class, 'menu');
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
                __DIR__ . '/../dist' => public_path('vendor/cms'),
            ], 'cms-assets');

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('cms.php'),
            ], 'cms-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'cms');

        $this->commands([
            PublishCommand::class,
            SeedCommand::class,
        ]);

        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}
