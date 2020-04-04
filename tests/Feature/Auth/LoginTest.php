<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Auth;

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login_route_is_accessible()
    {
        $this->get('/admin/login')->assertOk();
    }

    /** @test */
    public function it_redirects_after_successful_login()
    {
        $user = factory(User::class)->create(['password' => 'secret']);
        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect('/admin');
    }
}
