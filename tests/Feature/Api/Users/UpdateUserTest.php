<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Users;

use Bambamboole\LaravelCms\Core\Users\Models\User;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class UpdateUserTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        factory(User::class)->create();
        $response = $this->patch('/api/cms/user/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_unknown_id_returns_404()
    {
        $this->login();

        $response = $this->patch('/api/cms/user/1337', ['name' => 'updated_name']);

        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->login();

        $updateData = factory(User::class)->raw([
            'name' => 'updated_name',
            'password' => null
        ]);

        $response = $this->patch("/api/cms/user/{$user->id}", $updateData);

        $response->assertOk();
        $this->assertEquals('updated_name', $user->fresh()->name);
        $this->assertJsonSchema('responses/user', $response->getContent());
    }

    /**
     * @test
     * @dataProvider invalidData
     */
    public function data_needs_to_be_valid(string $errorKey, array $overrides)
    {
        $user = factory(User::class)->create();
        $this->login();

        $response = $this->patch("/api/cms/user/{$user->id}", factory(User::class)->raw($overrides));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorKey);
    }

    public function invalidData()
    {
        return [
            ['email', ['email' => 'invalid_email']],
        ];
    }

    /** @test */
    public function email_must_be_unique()
    {
        $user = factory(User::class)->create();
        $this->login(['email' => 'test@test.com']);

        $response = $this->patch("/api/cms/user/{$user->id}", [
            'name' => 'test',
            'email' => 'test@test.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
