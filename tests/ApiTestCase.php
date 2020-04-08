<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\Core\Users\Models\User;
use Bambamboole\LaravelCms\LaravelCmsServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PHPUnit\Framework\AssertionFailedError;
use sixlive\JsonSchemaAssertions\SchemaAssertion;

class ApiTestCase extends BaseTestCase
{
    protected $defaultHeaders = ['Accept' => 'application/json'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(['--path' => __DIR__.'/../migrations']);
        $this->loadMigrationsFrom(['--path' => __DIR__.'/../vendor/laravel/sanctum/database/migrations']);
        $this->withFactories(__DIR__.'/factories');
    }

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
            ->schema(__DIR__.'/../resources/open-api/'.$schema)
            ->assert($json);
    }

    protected function getPackageProviders($app)
    {
        return [
            SanctumServiceProvider::class,
            LaravelCmsServiceProvider::class,
        ];
    }

    protected function login(array $overrides = []): User
    {
        $user = factory(User::class)->create($overrides);
        Sanctum::actingAs($user);

        return $user;
    }
}
