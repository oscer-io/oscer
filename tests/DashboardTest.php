<?php

namespace Bambamboole\LaravelCms\Tests;

use Illuminate\Foundation\Auth\User;

class DashboardTest extends TestCase
{
    /** @test */
    public function login_route_is_accessible()
    {
        $this->actingAs(factory(User::class)->create());
        $this->get('/admin')->assertOk();
    }

}
