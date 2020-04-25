<?php

namespace Oscer\Cms\Frontend\Http\Controllers;

use Oscer\Cms\Core\Posts\Models\Post;
use Oscer\Cms\Frontend\Contracts\Theme;

class PostsController
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function index()
    {
        return view(
            $this->theme->getPostIndexTemplate(),
            [
                'posts' => Post::query()
                    ->where('type', 'post')
                    ->paginate(10),
            ]
        );
    }

    public function show(string $slug)
    {
        return view(
            $this->theme->getPostShowTemplate(),
            [
                'post' => Post::query()
                    ->where('type', 'post')
                    ->where('slug', $slug)
                    ->firstOrFail(),
            ]
        );
    }
}
