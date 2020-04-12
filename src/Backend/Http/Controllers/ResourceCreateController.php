<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\BackendRequest;

class ResourceCreateController
{
    public function handle(BackendRequest $request)
    {
        $model = $request->newResourceModel();
        $resourceClass = $request->getResource();

        return response()->json(['data' => new $resourceClass($model)]);
    }
}
