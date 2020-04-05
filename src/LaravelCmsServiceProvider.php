<?php

namespace Bambamboole\LaravelCms;

use Bambamboole\LaravelCms\Api\Routing\ApiRouter;
use Bambamboole\LaravelCms\Backend\Routing\BackendRouter;
use Bambamboole\LaravelCms\Backend\ViewComposer\BackendViewComposer;
use Bambamboole\LaravelCms\Core\Commands\Development\SeedCommand;
use Bambamboole\LaravelCms\Core\Commands\PublishCommand;
use Bambamboole\LaravelCms\Core\Permissions\Models\Permission;
use Bambamboole\LaravelCms\Core\Permissions\Models\Role;
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

        $backendRouter->registerAuthRoutes();
        $backendRouter->registerBackendRoutes();

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

    /**
     * Register the package's guard.
     */
    protected function registerGuard(Repository $config): void
    {
        $config->set('permission.models', [
            'permission' => Permission::class,
            'role'       => Role::class,
        ]);

        $config->set('auth.providers.cms_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $config->set('auth.guards.web', [
            'driver' => 'session',
            'provider' => 'cms_users',
        ]);
        $statefulHosts = $config->get('sanctum.stateful');
        $statefulHosts[] = $config->get('cms.backend.domain');

        $config->set('ziggy.whitelist', ['cms.*']);
        $config->set('ziggy.skip-route-function', true);
        $config->set('sanctum.stateful', $statefulHosts);
        $config->set('sanctum.middleware.verify_csrf_token', VerifyCsrfToken::class);
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
            SeedCommand::class,
        ]);

        $this->app->singleton('commonmark', function () {
        });

        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}
