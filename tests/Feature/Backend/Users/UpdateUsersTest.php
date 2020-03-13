<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Backend\Users;

use Bambamboole\LaravelCms\Models\User;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UpdateUsersTest extends TestCase
{
    /** @test */
    public function a_user_can_be_updated()
    {
        $user = $this->login();

        $this->put(route('cms.backend.users.update', $user), ['name' => 'updated']);

        $this->assertEquals('updated', $user->fresh()->name);
    }

    /** @test */
    public function the_password_cant_be_changed_from_update_user()
    {
        $user = $this->login();

        $this->put(route('cms.backend.users.update', $user), ['password' => 'test']);

        $this->assertFalse(Hash::check('test', $user->fresh()->getAuthPassword()));
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $this->login(['email' => 'test@test.com']);
        $user = factory(User::class)->create();

        $response = $this->put(route('cms.backend.users.update', $user), ['email' => 'test@test.com']);

        $response->assertSessionHasErrors('email');
    }
}
