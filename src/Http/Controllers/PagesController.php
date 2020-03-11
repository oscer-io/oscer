<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Http\Requests\CreatePageRequest;
use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function create()
    {
        return Inertia::render('Pages/Create', ['page' => new Page()]);
    }

    public function store(CreatePageRequest $request)
    {
        $page = Page::create(array_merge(
            [
                'author_id' => Auth::user()->id,
            ], $request->validated()));

        session()->flash('message', ['type' => 'success', 'text' => "Page {$page->name} created"]);

        return Redirect::route('cms.pages.show', ['page' => $page]);
    }
}
