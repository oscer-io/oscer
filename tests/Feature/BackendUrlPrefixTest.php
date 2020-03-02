<?php

namespace Bambamboole\LaravelCms\Tests;

class BackendUrlPrefixTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cms.backend.url', 'test');
    }

    /** @test */
    public function the_prefix_is_configurable()
    {
        $this->get('/test/login')->assertOk();
        $this->get('/test/password/forgot')->assertOk();
    }
}
