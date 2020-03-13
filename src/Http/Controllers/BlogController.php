<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\Post;
use Bambamboole\LaravelCms\Themes\Theme;

class BlogController
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function index()
    {
        return view($this->theme->getBlogIndexTemplate(), ['posts' => Post::all()]);
    }

    public function show(string $slug)
    {
        return view(
            $this->theme->getBlogPostTemplate(),
            ['posts' => Post::query()->where('slug', $slug)->firstOrFail()]
        );
    }
}
