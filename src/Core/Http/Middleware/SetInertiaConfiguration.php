<?php

namespace Bambamboole\LaravelCms\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Session;
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
            'flash' => [
                'message' => function () {
                    return Session::get('message');
                },
            ],
            'routes' => $routes,
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
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
