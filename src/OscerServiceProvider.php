<?php

namespace Oscer\Cms;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Oscer\Cms\Core\Commands\InstallCommand;
use Oscer\Cms\Core\Commands\PublishCommand;
use Oscer\Cms\Core\Commands\ResolveOptionsCommand;
use Oscer\Cms\Core\Models\Permission;
use Oscer\Cms\Core\Models\Role;
use Oscer\Cms\Core\Models\User;

class OscerServiceProvider extends ServiceProvider
{
    public function boot(Repository $config) {

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'cms');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');

        $this->configureOscer($config);

        $this->registerPublishes();

        Gate::before(function ($user, $ability) {
            return $user->hasRole(Role::SUPER_ADMIN_ROLE) ? true : null;
        });
    }

    protected function configureOscer(Repository $config): void
    {
        $config->set('auth.providers.cms_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $config->set('auth.guards.web', [
            'driver' => 'session',
            'provider' => 'cms_users',
        ]);

        $config->set('permission.models', [
            'permission' => Permission::class,
            'role' => Role::class,
        ]);

        $statefulHosts = $config->get('sanctum.stateful');
        $statefulHosts[] = $config->get('cms.backend.domain');

        $config->set('sanctum.stateful', $statefulHosts);
        $config->set('sanctum.middleware.verify_csrf_token', VerifyCsrfToken::class);
    }

    protected function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/stubs/CmsServiceProvider.stub' => app_path('Providers/CmsServiceProvider.php'),
            ], 'cms-provider');

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
            ResolveOptionsCommand::class,
            InstallCommand::class,
        ]);
    }
}
