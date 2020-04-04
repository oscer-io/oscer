<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceController
{
    public function index(string $resource)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasIndexEndpoint) {
            throw new NotFoundHttpException('resource has no index endpoint');
        }

        return $instance->executeIndex();
    }

    public function show(string $resource, $id)
    {
        $instance = $this->getResourceInstance($resource);
        if (! $instance instanceof HasShowEndpoint) {
            throw new NotFoundHttpException('resource has no show endpoint');
        }

        return $instance->executeShow($id);
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
