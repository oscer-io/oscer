<?php

namespace Bambamboole\LaravelCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SetInertiaRooView
{
    /**
     * Handle an incoming request.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::setRootView('cms::layouts.inertia');

        return $next($request);
    }
}
