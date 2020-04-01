<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Controllers;

use Bambamboole\LaravelCms\Publishing\Http\Requests\CreatePostRequest;
use Bambamboole\LaravelCms\Publishing\Http\Requests\UpdatePostRequest;
use Bambamboole\LaravelCms\Publishing\Http\Resources\PostResource;
use Bambamboole\LaravelCms\Publishing\Models\Post;

class PostsController
{
    public function index()
    {
        return PostResource::collection(Post::query()->paginate());
    }

    public function show(int $id)
    {
        return new PostResource(Post::query()->findOrFail($id));
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        $post = Post::query()->findOrFail($id);
        $post->update($request->validated());

        return new PostResource($post);
    }

    public function store(CreatePostRequest $request)
    {
        $post = Post::create(array_merge(['author_id' => auth()->user()->id], $request->validated()));

        return new PostResource($post);
    }

    public function delete(int $postId)
    {
        Post::query()->find($postId)->delete();

        return  ['success' => true];
    }
}
