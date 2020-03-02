<?php

namespace Bambamboole\LaravelCms\Tests\Feature;

use Bambamboole\LaravelCms\Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function forgot_password_route_is_accessible()
    {
        $this->get('/admin/password/forgot')->assertOk();
    }
}
