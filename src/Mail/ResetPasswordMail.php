<?php

namespace Bambamboole\LaravelCms\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    /**
     * The token for the reset.
     *
     * @var string
     */
    public $token;

    /**
     * New instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('cms.from_email'))
            ->subject('Reset your password')
            ->view('cms::mails.password-reset', [
                'link' => route('cms.password.reset', ['token' => $this->token]),
            ]);
    }
}
