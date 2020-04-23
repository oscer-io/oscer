<?php

namespace Oscer\Cms\Backend\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Oscer\Cms\Backend\Http\Requests\ResourceRequest;
use Oscer\Cms\Backend\Resources\Resource;

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
