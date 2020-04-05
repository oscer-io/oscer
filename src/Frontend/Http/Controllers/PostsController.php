<?php

namespace Bambamboole\LaravelCms\Frontend\Http\Controllers;

use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;

class PostsController
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function index()
    {
        return view($this->theme->getPostIndexTemplate(), ['posts' => Post::all()]);
    }

    public function show(string $slug)
    {
        return view(
            $this->theme->getPostShowTemplate(),
            ['post' => Post::query()->where('slug', $slug)->firstOrFail()]
        );
    }
}
