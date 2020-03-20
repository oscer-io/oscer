<?php

namespace Bambamboole\LaravelCms\Auth\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build(): self
    {
        return $this->from(config('cms.from_email'))
            ->subject('Reset your password')
            ->view('cms::mails.password-reset', [
                'link' => route('cms.password.reset', ['token' => $this->token]),
            ]);
    }
}
