<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Http\Request;

class PagesController
{
    public function show(Request $request)
    {
        $pathParts = explode('.', $request->route()->getName());
        $slug = end($pathParts);
        $page = Page::query()->where('slug', $slug)->firstOrFail();

        return view('cms::pages.show', ['page' => $page]);
    }
}
