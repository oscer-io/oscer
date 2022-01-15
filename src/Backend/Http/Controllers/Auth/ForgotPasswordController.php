<?php

namespace Oscer\Cms\Backend\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Oscer\Cms\Backend\Http\Requests\Auth\SendPasswordResetLinkRequest;
use Oscer\Cms\Core\Mails\ResetPasswordMail;
use Oscer\Cms\Core\Models\User;
use Throwable;

class ForgotPasswordController
{
    /**
     * Show the reset-password form.
     */
    public function showResetRequestForm(): View
    {
        return view('cms::auth.reset-request-form');
    }

    public function sendResetLinkEmail(SendPasswordResetLinkRequest $request): RedirectResponse
    {
        $user = User::query()->where('email', $request->input('email'))->first();

        $token = Cache::remember("password.reset.{$user->id}", now()->addMinutes(30), function () {
            return Str::random();
        });

        Mail::to($user->email)->send(new ResetPasswordMail(
            encrypt($user->id.'|'.$token)
        ));

        return redirect()->route('cms.password.forgot')->with('sent', true);
    }

    /**
     * Show the new password to the user.
     *
     * @throws \Exception
     */
    public function showNewPassword(string $token)
    {
        try {
            $token = decrypt($token);

            [$userId, $token] = explode('|', $token);

            /** @var \Oscer\Cms\Core\Models\User $user */
            $user = User::query()->findOrFail($userId);
        } catch (Throwable $e) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        if (cache("password.reset.{$userId}") != $token) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        cache()->forget("password.reset.{$userId}");

        $user->update(['password' => $password = Str::random()]);

        return view('cms::auth.reset-password', [
            'password' => $password,
        ]);
    }
}
