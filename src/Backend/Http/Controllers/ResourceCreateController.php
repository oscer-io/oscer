<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;

class ResourceCreateController
{
    public function handle(ResourceRequest $request)
    {
        $model = $request->newResourceModel();
        $resourceClass = $request->getResource();

        return response()->json(['data' => new $resourceClass($model)]);
    }
}
