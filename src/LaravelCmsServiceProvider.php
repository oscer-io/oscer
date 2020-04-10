<?php

namespace Bambamboole\LaravelCms;

use Bambamboole\LaravelCms\Api\Routing\ApiRouter;
use Bambamboole\LaravelCms\Backend\Routing\BackendRouter;
use Bambamboole\LaravelCms\Backend\ViewComposer\BackendViewComposer;
use Bambamboole\LaravelCms\Core\Commands\Development\SeedCommand;
use Bambamboole\LaravelCms\Core\Commands\PublishCommand;
use Bambamboole\LaravelCms\Core\Users\Models\Permission;
use Bambamboole\LaravelCms\Core\Users\Models\Role;
use Bambamboole\LaravelCms\Core\Users\Models\User;
use Bambamboole\LaravelCms\Frontend\BladeComponents\MenuBladeComponent;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Bambamboole\LaravelCms\Frontend\DefaultTheme;
use Bambamboole\LaravelCms\Frontend\ViewComposers\ThemeViewComposer;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;

class LaravelCmsServiceProvider extends ServiceProvider
{
    protected ApiRouter $apiRouter;

    protected BackendRouter $backendRouter;

    protected Repository $config;

    public function boot(
        ApiRouter $apiRouter,
        BackendRouter $backendRouter,
        BladeCompiler $blade,
        Factory $view,
        Repository $config,
        Theme $theme
    )
    {
        $this->apiRouter = $apiRouter;
        $this->backendRouter = $backendRouter;
        $this->config = $config;

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cms');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');

        $this->configureGuard();
        $this->configurePermissions();
        $this->configureSanctum();
        $this->configureZiggy();

        $this->registerPublishes();
        $this->registerRoutes();

        Gate::before(function ($user, $ability) {
            return $user->hasRole(Role::SUPER_ADMIN_ROLE) ? true : null;
        });

        $view->composer([
            $theme->getPostShowTemplate(),
            $theme->getPageTemplate(),
            $theme->getPostIndexTemplate(),
        ], ThemeViewComposer::class);
        $view->composer('cms::backend', BackendViewComposer::class);

        $blade->component(MenuBladeComponent::class, 'menu');
    }

    protected function configureGuard(): void
    {
        $this->config->set('auth.providers.cms_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $this->config->set('auth.guards.web', [
            'driver' => 'session',
            'provider' => 'cms_users',
        ]);

    }

    protected function configurePermissions()
    {
        $this->config->set('permission.models', [
            'permission' => Permission::class,
            'role' => Role::class,
        ]);
    }

    protected function configureZiggy()
    {
        $this->config->set('ziggy.whitelist', ['cms.*']);
        $this->config->set('ziggy.skip-route-function', true);
    }

    protected function configureSanctum()
    {
        $statefulHosts = $this->config->get('sanctum.stateful');
        $statefulHosts[] = $this->config->get('cms.backend.domain');


        $this->config->set('sanctum.stateful', $statefulHosts);
        $this->config->set('sanctum.middleware.verify_csrf_token', VerifyCsrfToken::class);
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

    protected function registerRoutes()
    {
        $this->apiRouter->registerApiRoutes();
        $this->backendRouter->registerAuthRoutes();
        $this->backendRouter->registerBackendRoutes();
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

        $this->app->singleton('commonmark', function () {
        });

        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}
