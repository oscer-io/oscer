<?php

namespace Bambamboole\LaravelCms\Frontend\Http\Controllers;

use Bambamboole\LaravelCms\Frontend\Theming\Contracts\Theme;
use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Publishing\Models\Page;
use Illuminate\Http\Request;

class PagesController
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function show(Request $request)
    {
        $pathParts = explode('.', $request->route()->getName());
        $slug = end($pathParts);
        $page = Page::query()->where('slug', $slug)->firstOrFail();

        return view($this->theme->getPageTemplate(), ['page' => $page]);
    }

    public function frontPage()
    {
        $page = Page::query()->where(
            'slug',
            Option::getValueByKey('pages.front_page')
        )->firstOrFail();

        return view($this->theme->getFrontPageTemplate(), ['page' => $page]);
    }
}
