<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceController
{
    public function index(ResourceRequest $request)
    {
        $resource = $request->getResource();
        $model = $request->newResourceModel();
        return $resource::asApiResourceCollection($model->index());
    }

    public function show(string $resource, $id)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasShowEndpoint) {
            throw new NotFoundHttpException('resource has no show endpoint');
        }

        return $instance->executeShow($id);
    }

    public function store(Request $request, string $resource)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasStoreEndpoint) {
            throw new NotFoundHttpException('resource has no store endpoint');
        }

        try {
            return $instance->executeStore($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->validator->errors()], 422);
        }
    }

    public function update(Request $request, string $resource, $identifier)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasUpdateEndpoint) {
            throw new NotFoundHttpException('resource has no update endpoint');
        }

        try {
            return $instance->executeUpdate($request, $identifier);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->validator->errors()], 422);
        }
    }

    public function delete(string $resource, $id)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasDeleteEndpoint) {
            throw new NotFoundHttpException('resource has no delete endpoint');
        }

        return $instance->executeDelete($id);
    }

    protected function getResourceInstance(string $resource): HasApiEndpoints
    {
        $resources = config('cms.resources');

        if (! array_key_exists($resource, $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        $resourceClass = $resources[$resource];
        $instance = new $resourceClass();

        if (! $instance instanceof HasApiEndpoints) {
            throw new NotFoundHttpException('Resource does not implement HasApiEndpoints');
        }

        return $instance;
    }
}
