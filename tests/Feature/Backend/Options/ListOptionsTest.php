<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Backend\Options;

use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Tests\TestCase;

class ListOptionsTest extends TestCase
{
    /** @test */
    public function the_user_needs_to_be_authenticated()
    {
        $this->get('/admin/options')->assertRedirect('/admin/login');
    }

    /** @test */
    public function options_can_be_retrieved()
    {
        $this->login();

        // @TODO better assertion
        $this->get('/admin/options')->assertOk();
    }
}
