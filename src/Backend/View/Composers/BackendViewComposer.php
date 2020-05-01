<?php

namespace Oscer\Cms\Backend\View\Composers;

use Illuminate\Routing\Router;
use Illuminate\View\View;
use Oscer\Cms\Backend\Routing\RouteGenerator;
use Oscer\Cms\Backend\Sidebar\Sidebar;
use Oscer\Cms\Backend\View\ScriptHandler;

class BackendViewComposer
{
    protected Router $router;

    protected RouteGenerator $generator;

    protected Sidebar $sidebar;

    protected ScriptHandler $handler;

    public function __construct(Router $router, RouteGenerator $generator, Sidebar $sidebar, ScriptHandler $handler)
    {
        $this->router = $router;
        $this->generator = $generator;
        $this->sidebar = $sidebar;
        $this->handler = $handler;
    }

    public function compose(View $view)
    {
        $view
            ->with('json', [
                'user' => auth()->user(),
                'routes' => $this->generator->generate(),
                'sidebar' => $this->sidebar,
            ])
            ->with('scripts', $this->handler->getScripts());
    }
}
