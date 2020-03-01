<?php


namespace Bambamboole\LaravelCms\Http\Controllers\Auth;


use Bambamboole\LaravelCms\Mail\ResetPasswordMail;
use Bambamboole\LaravelCms\Models\CmsUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ForgotPasswordController extends Controller
{
    /**
     * Show the reset-password form.
     */
    public function showResetRequestForm(): View
    {
        return view('cms::auth.reset-request-form');
    }

    /**
     * Send password reset email.
     */
    public function sendResetLinkEmail(): RedirectResponse
    {
        validator(request()->all(), [
            'email' => 'required|email',
        ])->validate();

        if ($user = CmsUser::query()->where('email', request('email'))->first()) {
            cache(['password.reset.'.$user->id => $token = Str::random()],
                now()->addMinutes(30)
            );
            dump($user);

            Mail::to($user->email)->send(new ResetPasswordMail(
                encrypt($user->id.'|'.$token)
            ));
        }

        return redirect()->route('cms.password.forgot')->with('sent', true);
    }

    /**
     * Show the new password to the user.
     * @throws \Exception
     */
    public function showNewPassword(string $token)
    {
        try {
            $token = decrypt($token);

            [$authorId, $token] = explode('|', $token);

            $author = CmsUser::query()->findOrFail($authorId);
        } catch (Throwable $e) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        if (cache('password.reset.'.$authorId) != $token) {
            return redirect()->route('cms.password.forgot')->with('invalidResetToken', true);
        }

        cache()->forget('password.reset.'.$authorId);

        $author->password = Hash::make($password = Str::random());

        $author->save();

        return view('cms::auth.reset-password', [
            'password' => $password,
        ]);
    }
}
