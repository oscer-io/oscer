<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Controllers;

use Bambamboole\LaravelCms\Publishing\Http\Requests\UpdatePostRequest;
use Bambamboole\LaravelCms\Publishing\Http\Resources\PostResource;
use Bambamboole\LaravelCms\Publishing\Models\Post;

class PostsController
{
    public function update(UpdatePostRequest $request, int $id)
    {
        $post = Post::query()->findOrFail($id);
        $post->update($request->validated());

        return new PostResource($post);
    }
}
