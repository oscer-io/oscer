<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Contracts\DisplayableModel;
use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;
use Illuminate\Contracts\Pagination\Paginator;

class ResourceIndexController
{
    public function handle(ResourceRequest $request)
    {
        $model = $request->newResourceModel();
        $collection = $model->index();
        $resourceClass = $request->getResource();

        if ($collection instanceof Paginator) {
            return response()->json([
                'data' => collect($collection->items())
                    ->map(function (DisplayableModel $model) use ($resourceClass) {
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

        return response()->json(['data' => $collection]);
    }
}
