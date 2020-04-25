<?php

namespace Oscer\Cms\Core\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    protected Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guard('sanctum')->check()) {
            $this->auth->shouldUse('sanctum');
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', ['sanctum'], route('cms.auth.login')
            );
        }

        return $next($request);
    }
}
