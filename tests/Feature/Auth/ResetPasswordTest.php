<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Auth;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ResetPasswordTest extends TestCase
{
    /** @test */
    public function password_reset_form_is_accessible_with_valid_token()
    {
        $user = factory(User::class)->create();
        Cache::shouldReceive('get')->once()->with("password.reset.{$user->id}")->andReturn('token');

        $response = $this->get(route('cms.password.reset', encrypt("{$user->id}|token")));
        $response->assertOk();
    }

    /** @test */
    public function password_reset_form_is_not_accessible_without_valid_token()
    {

        $response = $this->get(route('cms.password.reset', 'invalid_token'));

        $response->assertRedirect(route('cms.password.forgot'));
    }

    /** @test */
    public function password_must_be_confirmed()
    {
        // hint: assert session has errors
    }

    /** @test */
    public function password_can_be_updated()
    {
        // attention: assert with user credentials, attention pw is hashed
    }
}
