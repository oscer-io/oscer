<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\BackendRequest;

class ResourceShowController
{
    public function handle(BackendRequest $request)
    {
        $resourceModel = $request
            ->newResourceModel()
            ->show($request->identifier());
        $resourceClass = $request->getResource();

        return response()->json(['data' => new $resourceClass($resourceModel)]);
    }
}
