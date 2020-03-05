<?php

namespace Bambamboole\LaravelCms\Tests\Feature;

use Bambamboole\LaravelCms\Models\User;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /** @test */
    public function login_route_is_accessible()
    {
        $this->get('/admin/login')->assertOk();
    }

    /** @test */
    public function login_is_possible()
    {
        $user = factory(User::class)->create(['password' => 'secret']);
        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect('/admin/posts');
    }
}
