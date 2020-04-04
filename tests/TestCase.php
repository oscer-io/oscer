<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\LaravelCmsServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(['--path' => __DIR__.'/../migrations']);
        $this->withFactories(__DIR__.'/factories');
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
