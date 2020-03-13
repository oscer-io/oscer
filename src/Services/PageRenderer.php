<?php

namespace Bambamboole\LaravelCms\Services;

use Bambamboole\LaravelCms\Models\Page;
use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\Http\Request;

class PageRenderer
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function render(Request $request)
    {
        $slug = end(explode('.', $request->route()->getName()));
        $page = Page::query()->where('slug', $slug)->firstOrFail();

        return view($this->theme->getPageTemplate(), ['page' => $page]);
    }
}
