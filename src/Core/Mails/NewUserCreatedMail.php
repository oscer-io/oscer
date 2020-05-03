<?php

namespace Oscer\Cms\Core\Mails;

use Illuminate\Mail\Mailable;

class NewUserCreatedMail extends Mailable
{
    protected string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function build(): self
    {
        return $this->from(config('cms.from_email'))
            ->subject('Your password')
            ->view('cms::mails.your-password', [
                'password' => $this->password,
            ]);
    }
}
