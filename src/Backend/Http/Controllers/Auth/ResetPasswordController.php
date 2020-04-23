<?php

namespace Oscer\Cms\Backend\Http\Controllers\Auth;

use Oscer\Cms\Backend\Http\Requests\Auth\ResetPasswordRequest;
use Oscer\Cms\Core\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ResetPasswordController
{
    public function showResetForm(Request $request, $encryptedToken)
    {
        $user = $this->getUserFromEncryptedToken($encryptedToken);

        if ($user === false) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        return view('cms::auth.reset-password', compact('encryptedToken', 'user'));
    }

    public function update(ResetPasswordRequest $request)
    {
        $user = $this->getUserFromEncryptedToken($request->input('encrypted_token'));
        if ($user === false) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }
        $user->update(['password' => $request->input('password')]);

        Auth::guard()->login($user);

        return redirect()->route('cms.backend.start');
    }

    protected function getUserFromEncryptedToken($encryptedToken)
    {
        try {
            $token = decrypt($encryptedToken);
            [$userId, $token] = explode('|', $token);
            $user = User::query()->findOrFail($userId);
        } catch (Throwable $exception) {
            return false;
        }
        if (Cache::get("password.reset.{$userId}") != $token) {
            return false;
        }

        return $user;
    }
}
