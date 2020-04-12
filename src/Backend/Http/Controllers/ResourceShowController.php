<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;

class ResourceShowController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request
            ->newResourceModel()
            ->show($request->identifier());
        $resourceClass = $request->getResource();

        return response()->json(['data' => new $resourceClass($resourceModel)]);
    }
}
