<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\ResourceRequest;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Illuminate\Validation\ValidationException;

class ResourceStoreController
{
    public function handle(ResourceRequest $request)
    {
        $resourceClass = $request->getResource();
        $resourceModel = $request->newResourceModel();

        if ($request->identifier() !== null) {
            $resourceModel = $resourceModel->newQuery()->findOrFail($request->identifier());
        }

        /** @var resource $resource */
        $resource = new $resourceClass($resourceModel);

        try {
            $savedModel = $resource->save($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }

        return response()->json(['data' => new $resourceClass($savedModel)]);
    }
}
