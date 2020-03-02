<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Inertia\Inertia;

class PagesController
{
    public function index()
    {
        return Inertia::render('Pages/Index');
    }
}
