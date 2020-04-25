<?php

namespace Oscer\Cms;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;
use Oscer\Cms\Api\Routing\ApiRouter;
use Oscer\Cms\Backend\Routing\BackendRouter;
use Oscer\Cms\Backend\ViewComposer\BackendViewComposer;
use Oscer\Cms\Core\Commands\Development\SeedCommand;
use Oscer\Cms\Core\Commands\PublishCommand;
use Oscer\Cms\Core\Commands\ResolveOptionsCommand;
use Oscer\Cms\Core\Users\Models\Permission;
use Oscer\Cms\Core\Users\Models\Role;
use Oscer\Cms\Core\Users\Models\User;
use Oscer\Cms\Frontend\BladeComponents\MenuBladeComponent;
use Oscer\Cms\Frontend\Contracts\Theme;
use Oscer\Cms\Frontend\DefaultTheme;
use Oscer\Cms\Frontend\ViewComposers\ThemeViewComposer;

class OscerServiceProvider extends ServiceProvider
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
    ) {
        $this->apiRouter = $apiRouter;
        $this->backendRouter = $backendRouter;
        $this->config = $config;

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');

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
                __DIR__.'/../dist' => public_path('vendor/cms'),
            ], 'cms-assets');

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('cms.php'),
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'cms');

        $this->commands([
            PublishCommand::class,
            SeedCommand::class,
            ResolveOptionsCommand::class,
        ]);

        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}