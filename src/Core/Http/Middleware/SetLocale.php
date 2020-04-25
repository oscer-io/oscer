<?php

namespace Oscer\Cms\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class SetLocale
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $this->app->setLocale(auth()->user()->language);
        } else {
            $this->app->setLocale('en');
        }

        return $next($request);
    }
}
