<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\LaravelCmsServiceProvider;
use Bambamboole\LaravelCms\Auth\Models\User;
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
        return [LaravelCmsServiceProvider::class];
    }

    protected function login(array $overrides = []): User
    {
        $user = factory(User::class)->create($overrides);
        $this->actingAs($user, 'cms');

        return $user;
    }
}
