<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\Core\Users\Models\Role;
use Bambamboole\LaravelCms\Core\Users\Models\User;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\AssertionFailedError;
use sixlive\JsonSchemaAssertions\SchemaAssertion;

class ApiTestCase extends TestCase
{
    protected $defaultHeaders = ['Accept' => 'application/json'];

    /**
     * @param array|string $schema
     * @param string . $json
     * @return void
     *
     * @throws AssertionFailedError
     */
    public function assertJsonSchema($schema, string $json): void
    {
        (new SchemaAssertion())
            ->schema(__DIR__ . '/../resources/open-api/' . $schema)
            ->assert($json);
    }

    protected function login(array $overrides = []): User
    {
        $user = factory(User::class)->create($overrides)->assignRole(Role::SUPER_ADMIN_ROLE);
        Sanctum::actingAs($user);

        return $user;
    }
}
