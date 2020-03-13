<?php

namespace Bambamboole\LaravelCms\Services;

use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Http\Request;

class PageRenderer
{
    public function render(Request $request)
    {
        $pathParts = explode('.', $request->route()->getName());
        $slug = end($pathParts);
        $page = Page::query()->where('slug', $slug)->firstOrFail();

        return view('cms::pages.show', ['page' => $page]);
    }
}
