<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

use Bambamboole\LaravelCms\Http\Requests\CreatePageRequest;
use Bambamboole\LaravelCms\Http\Requests\UpdatePageRequest;
use Bambamboole\LaravelCms\Models\Page;
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
        return Inertia::render('Pages/Create');
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->validated());

        session()->flash('message', ['type' => 'success', 'text' => "Page {$page->name} updated"]);

        return Redirect::route('cms.backend.pages.show', ['page' => $page]);
    }

    public function store(CreatePageRequest $request)
    {
        $page = Page::create(array_merge(
            [
                'author_id' => auth()->user()->id,
            ], $request->validated()));

        session()->flash('message', ['type' => 'success', 'text' => "Page {$page->name} created"]);

        return Redirect::route('cms.backend.pages.show', ['page' => $page]);
    }

    public function delete(int $pageId)
    {
        $page = Page::query()->find($pageId);
        $page->delete();

        session()->flash('message', ['type' => 'success', 'text' => 'Page deleted']);

        return Redirect::route('cms.backend.pages.index');
    }
}
