<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\Page;
use Inertia\Inertia;

class PagesController
{
    public function index()
    {
        return Inertia::render('Pages/Index', ['pages' => Page::all()]);
    }

    public function show(Page $page)
    {
        return Inertia::render('Pages/Show', ['page' => $page]);
    }

    public function edit(Page $page)
    {
        return Inertia::render('Pages/Edit', ['page' => $page]);
    }
}
