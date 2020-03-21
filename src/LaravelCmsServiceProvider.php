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
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;

class LaravelCmsServiceProvider extends ServiceProvider
{
    public function boot(
        ApiRouter $apiRouter,
        BackendRouter $backendRouter,
        BladeCompiler $blade,
        Factory $view,
        Repository $config,
        Theme $theme
    ) {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        $this->registerGuard($config);
        $this->registerPublishes();

        $apiRouter->registerApiRoutes();
        $apiRouter->withSwaggerUi();

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
    protected function registerGuard(Repository $config): void
    {
        $config->set('auth.providers.cms_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $config->set('auth.guards.cms', [
            'driver' => 'session',
            'provider' => 'cms_users',
        ]);
    }

    protected function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../dist' => public_path('vendor/cms'),
                __DIR__.'/../resources/open-api' => public_path('vendor/cms/open-api'),
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
            SeedCommand::class,
        ]);

        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}
