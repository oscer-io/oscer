<?php


namespace Bambamboole\LaravelCms\Tests;


use Bambamboole\LaravelCms\LaravelCmsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations();
        $this->withFactories(__DIR__ . '/factories');
    }

    protected function getPackageProviders($app)
    {
        return [LaravelCmsServiceProvider::class];
    }
}
