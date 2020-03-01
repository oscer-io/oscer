<?php

namespace Bambamboole\LaravelCms\Tests;

use Illuminate\Foundation\Auth\User;

class DashboardUrlPrefixTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cms.dashboard.url', 'test');
    }

    /** @test */
    public function the_prefix_is_configurable()
    {
        $this->actingAs(factory(User::class)->create());
        $this->get('/test')->assertOk();
    }
}
