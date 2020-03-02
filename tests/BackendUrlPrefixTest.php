<?php

namespace Bambamboole\LaravelCms\Tests;

use Bambamboole\LaravelCms\Models\CmsUser;
use Illuminate\Foundation\Mix;

class BackendUrlPrefixTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cms.backend.url', 'test');
    }

    /** @test */
    public function the_prefix_is_configurable()
    {
        $this->actingAs(factory(CmsUser::class)->create(), 'cms');
        $this->get('/test/posts')->assertOk();
    }
}
