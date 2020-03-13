<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\Post;

class PostsController
{
    public function index()
    {
        return view('cms::blog.index', ['posts' => Post::all()]);
    }

    public function show(string $slug)
    {
        return view('cms::blog.show', ['posts' => Post::query()->where('slug', $slug)->firstOrFail()]);
    }
}
