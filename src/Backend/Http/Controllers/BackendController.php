<?php

namespace Oscer\Cms\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class BackendController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function show(Request $request)
    {
        return view('cms::backend', [
            'user' => $request->user(),
            'routes' => $this->getRoutes(),
        ]);
    }

    public function getRoutes()
    {
        return collect($this->router->getRoutes()->getRoutesByName())
            ->filter(function ($value, $key) {
                return strpos($key, 'cms.') !== false;
            })->map(function (Route $value, $key) {
                return "/{$value->uri()}";
            })->toArray();
    }
}
