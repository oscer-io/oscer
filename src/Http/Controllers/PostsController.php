<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Http\Requests\CreatePostRequest;
use Bambamboole\LaravelCms\Models\Post;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostsController
{
    public function index()
    {
        return Inertia::render('Posts/Index', ['posts' => Post::all()]);
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(CreatePostRequest $request)
    {
        $post = Post::query()->create(array_merge(['author_id' => auth()->user()->id], $request->validated()));

        session()->flash('message', ['type' => 'success', 'text' => __('cms::posts.toast.created')]);

        return Redirect::route('cms.posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', ['post' => $post]);
    }

    public function update(CreatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        session()->flash('message', ['type' => 'success', 'text' => __('cms::posts.toast.updated')]);

        return Redirect::route('cms.posts.show', ['post' => $post]);
    }
}
