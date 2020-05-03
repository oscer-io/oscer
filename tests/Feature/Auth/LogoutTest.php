<?php

namespace Oscer\Cms\Tests\Feature\Auth;

use Oscer\Cms\Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function it_redirects_after_successful_login()
    {
        $user = $this->login();
        $this->assertAuthenticatedAs($user);

        $this->get('/admin/logout')
            ->assertRedirect(route('cms.auth.login'));
    }
}
