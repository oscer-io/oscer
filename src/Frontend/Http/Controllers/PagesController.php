<?php

namespace Oscer\Cms\Frontend\Http\Controllers;

use Oscer\Cms\Core\Options\Models\Option;
use Oscer\Cms\Core\Pages\Models\Page;
use Oscer\Cms\Frontend\Contracts\Theme;
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
        $page = Page::query()->where('type', 'page')->where('slug', $slug)->firstOrFail();

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
