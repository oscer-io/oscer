<?php

namespace Bambamboole\LaravelCms\Tests;

class LoginTest extends TestCase
{
    /** @test */
    public function login_route_is_accessible()
    {
        $this->get('/admin/login')->assertOk();
    }
}
