<?php

namespace Bambamboole\LaravelCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Translation\Translator;

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
