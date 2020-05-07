<?php

namespace Oscer\Cms\Backend\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Oscer\Cms\Backend\Http\Requests\ResourceRequest;

class ResourceIndexController
{
    protected string $resourceClass;

    public function handle(ResourceRequest $request)
    {
        $this->resourceClass = $request->getResource();

        $query = $this->prepareQuery($request);
        $collection = $query->paginate(10);

        return response()->json([
            'data' => collect($collection->items())
                ->map(function (Model $model) {
                    return new $this->resourceClass($model);
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

    protected function prepareQuery(ResourceRequest $request)
    {
        $resourceModel = $request->getResourceModel();

        /** @var Builder $query */
        $query = $resourceModel::query();

        if ($search = $request->query('search')) {
            foreach ($this->resourceClass::$searchColumns as $column) {
                $query->orWhere($column, 'like', "%{$search}%");
            }
        }

        return $query;
    }
}
