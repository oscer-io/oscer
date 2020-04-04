<?php


namespace Bambamboole\LaravelCms\Auth\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Http\Requests\ResetPasswordRequest;
use Bambamboole\LaravelCms\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ResetPasswordController
{

    public function showResetForm(Request $request, $encryptedToken)
    {
        /** @var \Bambamboole\LaravelCms\Auth\Models\User $user */
        $user = $this->getUserFromEncryptedToken($encryptedToken);

        if ($user === false) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        return view('cms::auth.reset-password', compact('encryptedToken', 'user'));
    }

    public function update(ResetPasswordRequest $request)
    {
        /** @var \Bambamboole\LaravelCms\Auth\Models\User $user */
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
            /** @var \Bambamboole\LaravelCms\Auth\Models\User $user */
            $user = User::query()->findOrFail($userId);

        } catch (Throwable $exception) {
            return false;
        }
        if (cache("password.reset.{$userId}") != $token) {
            return false;
        }

        return $user;
    }

}
