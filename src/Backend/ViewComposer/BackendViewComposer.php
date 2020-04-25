<?php

namespace Oscer\Cms\Backend\ViewComposer;

use Illuminate\Routing\Router;
use Illuminate\View\View;
use Oscer\Cms\Backend\Routing\RouteGenerator;
use Oscer\Cms\Backend\Sidebar\Sidebar;

class BackendViewComposer
{
    protected Router $router;

    protected RouteGenerator $generator;

    protected Sidebar $sidebar;

    public function __construct(Router $router, RouteGenerator $generator, Sidebar $sidebar)
    {
        $this->router = $router;
        $this->generator = $generator;
        $this->sidebar = $sidebar;
    }

    public function compose(View $view)
    {
        $view->with('json', [
            'user' => auth()->user(),
            'routes' => $this->generator->generate(),
            'sidebar' => $this->sidebar,
        ]);
    }
}
