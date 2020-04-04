<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Users;

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class ListUsersTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->get('/api/cms/user');

        $response->assertStatus(401);
    }

    /** @test */
    public function users_can_be_fetched()
    {
        $this->login();
        factory(User::class, 5)->create();

        $response = $this->get('/api/cms/user');

        $response->assertOk();
        $this->assertJsonSchema('responses/user-collection', $response->getContent());
    }
}
