<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Inertia\Inertia;

class PostsController
{
    public function index()
    {
        return Inertia::render('Posts');
    }
}
