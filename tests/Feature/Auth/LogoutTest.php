<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Auth;

use Bambamboole\LaravelCms\Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function it_redirects_after_successful_login()
    {
        $user = $this->login();
        $this->assertAuthenticatedAs($user);

        $this->get('/admin/logout');

        $this->assertGuest();
    }
}
