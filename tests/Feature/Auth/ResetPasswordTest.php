<?php

namespace Oscer\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Oscer\Cms\Core\Users\Models\User;
use Oscer\Cms\Tests\TestCase;

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
        $response = $this->post(
            route('cms.password.update', 'token'),
            [
                'password' => 'secret',
                'password_confirmation' => 'not_secret',
            ]
        );

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function password_must_be_at_least_6_characters_long()
    {
        $response = $this->post(
            route('cms.password.update'),
            [
                'password' => '123',
                'password_confirmation' => '123',
            ]
        );

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function encrypted_token_is_required()
    {
        $response = $this->post(
            route('cms.password.update'),
            [
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]
        );

        $response->assertSessionHasErrors('encrypted_token');
    }

    /** @test */
    public function password_can_be_updated()
    {
        $user = factory(User::class)->create();
        Cache::shouldReceive('get')->once()->with("password.reset.{$user->id}")->andReturn('token');

        $this->post(
            route('cms.password.update'),
            [
                'encrypted_token' => encrypt("{$user->id}|token"),
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]
        );

        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function after_password_reset_the_user_will_be_logged_in()
    {
        $user = factory(User::class)->create();
        Cache::shouldReceive('get')->once()->with("password.reset.{$user->id}")->andReturn('token');

        $response = $this->post(
            route('cms.password.update'),
            [
                'encrypted_token' => encrypt("{$user->id}|token"),
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]
        );

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('cms.backend.start'));
    }
}
