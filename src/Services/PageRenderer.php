<?php


namespace Bambamboole\LaravelCms\Services;


use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Http\Request;

class PageRenderer
{
    public function render(Request $request)
    {
        $slug = end(explode('/', $request->path()));
        $page = Page::query()->where('slug', $slug)->firstOrFail();

        return view('cms::pages.show', ['page' => $page]);
    }
}
