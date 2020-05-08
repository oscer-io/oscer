<?php

namespace Oscer\Cms\Backend;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Oscer\Cms\Backend\Routing\BackendRouter;
use Oscer\Cms\Backend\Sidebar\Sidebar;
use Oscer\Cms\Backend\Sidebar\SidebarItem;
use Oscer\Cms\Backend\View\Composers\BackendViewComposer;
use Oscer\Cms\Backend\View\ScriptHandler;

class BackendServiceProvider extends ServiceProvider
{
    public function boot(BackendRouter $backendRouter, Factory $view, Repository $config, Sidebar $sidebar)
    {
        $config->set('ziggy.whitelist', ['cms.*']);
        $config->set('ziggy.skip-route-function', true);
        $config->set('blade-icons.sets.cms', ['path' => 'vendor/oscer-io/oscer/resources/icons', 'prefix' => 'cms']);

        $backendRouter->registerAuthRoutes();
        $backendRouter->registerBackendRoutes();

        $view->composer('cms::backend', BackendViewComposer::class);

        $sidebar
            ->addItem(new SidebarItem('folder', 'Pages', 'pages.index', 'pages.view'))
            ->addItem(new SidebarItem('folder', 'Posts', 'posts.index', 'posts.view'))
            ->addItem(new SidebarItem('folder', 'Menus', 'menus.index', 'menus.view'))
            ->addItem(new SidebarItem('folder', 'Options', 'options.index', 'options.view'))
            ->addItem(new SidebarItem('folder', 'Users', 'users.index', 'users.view'))
            ->addItem(new SidebarItem('folder', 'Roles', 'roles.index', 'roles.view'));
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Sidebar::class, Sidebar::class);
        $this->app->singleton(ScriptHandler::class, ScriptHandler::class);
    }
}
