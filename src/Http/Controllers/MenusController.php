<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Inertia\Inertia;

class MenusController
{
    public function index()
    {
        return Inertia::render('Menus/Index');
    }
}
