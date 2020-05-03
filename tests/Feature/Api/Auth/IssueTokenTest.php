<?php

namespace Oscer\Cms\Tests\Feature\Api\Auth;

use Oscer\Cms\Core\Models\User;
use Oscer\Cms\Tests\ApiTestCase;

class IssueTokenTest extends ApiTestCase
{
    /** @test */
    public function the_email_is_required()
    {
        $response = $this->post('/api/cms/auth/token', []);

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function the_password_is_required()
    {
        $response = $this->post('/api/cms/auth/token', ['email' => 'test@test.com']);

        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function a_token_can_be_issued()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['password' => 'secret']);

        $response = $this->post('/api/cms/auth/token', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertStatus(201);
        $this->assertJsonSchema('responses/issue-token', $response->getContent());
    }
}
