<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\Post;

class PostsController
{
    public function index()
    {
        return view('cms::posts.index', ['posts' => Post::all()]);
    }

    public function show(string $slug)
    {
        return view('cms::posts.show', ['posts' => Post::query()->where('slug', $slug)->firstOrFail()]);
    }
}
