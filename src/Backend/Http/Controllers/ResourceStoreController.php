<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\BackendRequest;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Illuminate\Validation\ValidationException;

class ResourceStoreController
{
    public function handle(BackendRequest $request)
    {
        $model = $request
            ->newResourceModel()
            ->show($request->identifier());

        $resourceClass = $request->getResource();
        /** @var Resource $resource */
        $resource = new $resourceClass($model);

        try {
            $savedModel = $resource->save($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }

        return response()->json(['data' => new $resourceClass($savedModel)]);
    }
}
