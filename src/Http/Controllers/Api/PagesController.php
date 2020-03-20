<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Api;

use Bambamboole\LaravelCms\Http\Resources\PageResource;
use Bambamboole\LaravelCms\Models\Page;
use Bambamboole\LaravelCms\Models\Post;

class PagesController
{
    public function index()
    {
        return PageResource::collection(Page::query()->paginate());
    }

    public function show(Post $post)
    {
        return new PageResource($post);
    }
}
