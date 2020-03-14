<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Auth;

use Bambamboole\LaravelCms\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function showLoginForm()
    {
        return view('cms::auth.login');
    }

    public function login(LoginRequest $request)
    {
        if ($this->guard()->attempt($request->validated(), $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('cms.backend.posts.index');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('cms.auth.login')->with('loggedOut', true);
    }

    protected function guard(): StatefulGuard
    {
        return Auth::guard('cms');
    }
}
