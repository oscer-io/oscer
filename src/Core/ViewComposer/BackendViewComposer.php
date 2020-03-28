<?php

namespace Bambamboole\LaravelCms\Core\ViewComposer;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\View\View;

class BackendViewComposer
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function compose(View $view)
    {
        $view->with('json', [
            'user' => auth()->user(),
            'routes' => $this->getRoutes()
        ]);
    }


    protected function getRoutes()
    {
        return collect($this->router->getRoutes()->getRoutesByName())
            ->filter(function ($value, $key) {
                return strpos($key, 'cms.') !== false;
            })->map(function (Route $value, $key) {
                return [
                    'method' => strtolower($value->methods()[0]),
                    'uri' => "/{$value->uri()}"
                ];
            })->toArray();
    }
}
