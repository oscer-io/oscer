<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class UpdateProfileTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->patch('/api/cms/profile');

        $response->assertStatus(401);
    }

    /** @test */
    public function the_profile_can_be_updated()
    {
        $user = $this->login();

        $response = $this->patch("/api/cms/profile", ['name' => 'updated_name']);

        $response->assertOk();
        $this->assertEquals('updated_name', $user->fresh()->name);
        $this->assertJsonSchema('responses/user', $response->getContent());
    }

    /**
     * @test
     * @dataProvider invalidData
     */
    public function data_needs_to_be_valid(string $errorKey, array $data)
    {
        $this->login();

        $response = $this->patch("/api/cms/profile", $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorKey);
    }

    public function invalidData()
    {
        return [
            ['name', ['name' => '']],
            ['email', ['email' => '']],
            ['email', ['email' => 'no_valid_mail']],
            ['bio', ['bio' => '']],
        ];
    }

    /** @test */
    public function email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'test@test.com']);
        $this->login();

        $response = $this->patch("/api/cms/profile", ['email' => 'test@test.com']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
