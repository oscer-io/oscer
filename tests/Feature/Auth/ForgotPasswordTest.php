<?php

namespace Oscer\Cms\Tests\Feature\Auth;

use Oscer\Cms\Core\Mails\ResetPasswordMail;
use Oscer\Cms\Core\Users\Models\User;
use Oscer\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function forgot_password_route_is_accessible()
    {
        $this->get('/admin/password/forgot')->assertOk();
    }

    /** @test */
    public function it_sends_an_email_to_a_valid_email()
    {
        Mail::fake();
        $user = factory(User::class)->create();

        $this->post('/admin/password/forgot', ['email' => $user->email]);

        Mail::assertSent(ResetPasswordMail::class);
    }
}
