<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Users;

use Bambamboole\LaravelCms\Core\Users\Models\User;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class DeleteUserTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        factory(User::class)->create();
        $response = $this->delete('/api/cms/user/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_unknown_id_returns_404()
    {
        $this->login();

        $response = $this->delete('/api/cms/user/1337');

        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $this->login();
        $this->assertEquals(2, User::query()->count());

        $response = $this->delete("/api/cms/user/{$user->id}");

        $response->assertOk();
        $this->assertEquals(1, User::query()->count());
    }
}
