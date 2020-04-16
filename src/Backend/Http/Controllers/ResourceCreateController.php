<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\ResourceRequest;

class ResourceCreateController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request->newResourceModel();
        $resourceClass = $request->getResource();

        return response()->json(['data' => new $resourceClass($resourceModel)]);
    }
}
