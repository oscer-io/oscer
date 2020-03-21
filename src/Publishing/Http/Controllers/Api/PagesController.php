<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Controllers\Api;

use Bambamboole\LaravelCms\Publishing\Http\Resources\PageResource;
use Bambamboole\LaravelCms\Publishing\Models\Page;

class PagesController
{
    public function index()
    {
        return PageResource::collection(Page::query()->paginate());
    }

    public function show(int $id)
    {
        return new PageResource(Page::query()->firstOrFail($id));
    }
}
