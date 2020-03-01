<?php


namespace Bambamboole\LaravelCms\Http\Controllers\Auth;


use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    use AuthenticatesUsers, ValidatesRequests;

    public function showLoginForm()
    {
        return view('cms::auth.login');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('cms.auth.login')->with('loggedOut', true);
    }

    /**
     * Get the post login redirect path.
     */
    public function redirectPath(): string
    {
        return '/' . config('cms.dashboard.url_prefix');
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard('cms');
    }

}
