<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Auth;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
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
        $response = $this->post(
            route('cms.password.update', 'token'),
            [
                'password' => 'secret_pw',
                'password_confirmation' => 'none_secret_pw',
            ]
        );

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function password_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        Cache::shouldReceive('get')->once()->with("password.reset.{$user->id}")->andReturn('token');

        $response = $this->post(
            route('cms.password.update', encrypt("{$user->id}|token")),
            [
                'password' => 'secret_pw',
                'password_confirmation' => 'secret_pw',
            ]
        );
        dd($response->status());

        $this->assertEquals($user->password, $user->fresh()->password);
//        $this->assertTrue(Hash::check('secret_pw',$user->fresh()->password));
    }
}
