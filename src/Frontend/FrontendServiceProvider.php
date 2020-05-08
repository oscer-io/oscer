<?php

namespace Oscer\Cms\Frontend;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Factory;
use Oscer\Cms\Frontend\Contracts\Theme;
use Oscer\Cms\Frontend\View\Components\MenuBladeComponent;
use Oscer\Cms\Frontend\View\Composers\ThemeViewComposer;

class FrontendServiceProvider extends ServiceProvider
{
    public function boot(BladeCompiler $blade, Factory $view, Theme $theme)
    {
        $view->composer([
            $theme->getPostShowTemplate(),
            $theme->getPageTemplate(),
            $theme->getPostIndexTemplate(),
        ], ThemeViewComposer::class);

        $blade->component(MenuBladeComponent::class, 'menu');
    }

    public function register()
    {
        $this->app->singleton(Theme::class, function () {
            return new DefaultTheme();
        });
    }
}
