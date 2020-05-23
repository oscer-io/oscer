<?php

namespace Oscer\Cms\Tests;

use Illuminate\Translation\TranslationServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Oscer\Cms\Api\ApiServiceProvider;
use Oscer\Cms\Backend\BackendServiceProvider;
use Oscer\Cms\Core\Models\User;
use Oscer\Cms\Frontend\FrontendServiceProvider;
use Oscer\Cms\OscerServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(['--path' => __DIR__.'/../migrations']);
        $this->loadMigrationsFrom(['--path' => __DIR__.'/../vendor/laravel/sanctum/database/migrations']);
        $this->withFactories(__DIR__.'/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            SanctumServiceProvider::class,
            PermissionServiceProvider::class,
            OscerServiceProvider::class,
            FrontendServiceProvider::class,
            BackendServiceProvider::class,
            ApiServiceProvider::class,
            TranslationServiceProvider::class,
        ];
    }

    protected function login(array $overrides = []): User
    {
        $user = factory(User::class)->create($overrides);
        Sanctum::actingAs($user);

        return $user;
    }
}
