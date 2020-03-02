<?php

namespace Bambamboole\LaravelCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Inertia\Inertia;

class SetInertiaConfiguration
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::setRootView('cms::layouts.inertia');

        $routes = collect($this->router->getRoutes()->getRoutesByName())
            ->filter(function ($value, $key) {
                return strpos($key, 'cms.') !== false;
            })->map(function (\Illuminate\Routing\Route $value, $key) {
                return "/{$value->uri()}";
            })->toArray();

        Inertia::share([
            'routes' => $routes,
            'auth' => function () {
                return [
                    'user' => auth()->user() ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'bio' => auth()->user()->bio,
                        'avatar' => auth()->user()->avatar,
                    ] : null,
                ];
            },
        ]);

        return $next($request);
    }
}
