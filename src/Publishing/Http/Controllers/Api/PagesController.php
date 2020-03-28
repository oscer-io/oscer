<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Controllers\Api;

use Bambamboole\LaravelCms\Publishing\Http\Requests\CreatePageRequest;
use Bambamboole\LaravelCms\Publishing\Http\Requests\UpdatePageRequest;
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
        return new PageResource(Page::query()->with('author')->findOrFail($id));
    }

    public function store(CreatePageRequest $request)
    {
        $page = Page::query()->create(array_merge(
            [
                'author_id' => auth()->user()->id,
            ], $request->validated()));

        return (new PageResource($page))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePageRequest $request, int $id)
    {
        $page = Page::query()->findOrFail($id);
        $page->update($request->validated());

        return new PageResource($page);
    }

    public function delete(int $id)
    {
        Page::query()->findOrFail($id)->delete();

        return ['success' => true];
    }
}
