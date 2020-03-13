<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

use Bambamboole\LaravelCms\Http\Requests\CreatePostRequest;
use Bambamboole\LaravelCms\Http\Requests\UpdatePostRequest;
use Bambamboole\LaravelCms\Models\Post;
use Bambamboole\LaravelCms\Models\Tag;
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

    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', ['post' => $post, 'tags' => Tag::all()->pluck('name')]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create', ['tags' => Tag::all()->pluck('name')]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        session()->flash('message', ['type' => 'success', 'text' => __('cms::posts.toast.updated')]);

        return Redirect::route('cms.backend.posts.show', ['post' => $post]);
    }

    public function store(CreatePostRequest $request)
    {
        $data = $request->validated();
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }
        $post = Post::query()->create(array_merge(['author_id' => auth()->user()->id], $data));

        ! isset($tags) ?: $post->update(['tags' => $tags]);

        session()->flash('message', ['type' => 'success', 'text' => __('cms::posts.toast.created')]);

        return Redirect::route('cms.backend.posts.show', ['post' => $post]);
    }

    public function delete(int $postId)
    {
        $post = Post::query()->find($postId);
        $post->delete();

        session()->flash('message', ['type' => 'success', 'text' => 'Post deleted']);

        return Redirect::route('cms.backend.posts.index');
    }
}