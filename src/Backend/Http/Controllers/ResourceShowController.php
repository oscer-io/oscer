<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\ResourceRequest;

class ResourceShowController
{
    public function handle(ResourceRequest $request)
    {
        $resourceClass = $request->getResource();
        $resourceModel = $request
            ->newResourceModel()
            ->newQuery()
            ->findOrFail($request->identifier());

        return response()->json(['data' => new $resourceClass($resourceModel)]);
    }
}
