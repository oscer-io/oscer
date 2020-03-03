<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\CmsPage;
use Inertia\Inertia;

class PagesController
{
    public function index()
    {
        return Inertia::render('Pages/Index', ['pages' => CmsPage::all()]);
    }

    public function show(CmsPage $page)
    {
        return Inertia::render('Pages/Show', ['page' => $page]);
    }
}
