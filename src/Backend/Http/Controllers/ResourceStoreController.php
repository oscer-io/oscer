<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResourceStoreController
{
    public function handle(ResourceRequest $request)
    {
        $model = $request->newResourceModel();

        if ($request->identifier() !== null) {
            $model = $model->show($request->identifier());
        }

        if (! $model instanceof SavableModel) {
            throw new HttpException(401, 'THe reosurce model is not savable');
        }

        $resourceClass = $request->getResource();
        /** @var resource $resource */
        $resource = new $resourceClass($model);

        try {
            $savedModel = $resource->save($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }

        return response()->json(['data' => new $resourceClass($savedModel)]);
    }
}
