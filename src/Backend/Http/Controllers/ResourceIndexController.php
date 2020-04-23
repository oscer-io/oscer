<?php

namespace Oscer\Cms\Backend\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Oscer\Cms\Backend\Http\Requests\ResourceRequest;

class ResourceIndexController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request->newResourceModel();
        $collection = $resourceModel->newQuery()->paginate(10);
        $resourceClass = $request->getResource();

        return response()->json([
            'data' => collect($collection->items())
                ->map(function (Model $model) use ($resourceClass) {
                    return new $resourceClass($model);
                })->toArray(),
            'meta' => [
                'total' => $collection->total(),
                'from' => $collection->firstItem(),
                'to' => $collection->lastItem(),
                'current_page' => $collection->currentPage(),
                'first_page_url' => $collection->url(1),
                'last_page' => $collection->lastPage(),
                'last_page_url' => $collection->url($collection->lastPage()),
                'next_page_url' => $collection->nextPageUrl(),
                'path' => $collection->path(),
                'per_page' => $collection->perPage(),
                'prev_page_url' => $collection->previousPageUrl(),
            ],
        ]);
    }
}
