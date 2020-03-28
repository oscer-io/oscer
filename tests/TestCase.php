<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\LaravelCmsServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\Permission\PermissionServiceProvider;

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
            PermissionServiceProvider::class,
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
