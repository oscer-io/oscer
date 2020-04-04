<?php


namespace Bambamboole\LaravelCms\Api\Http\Controllers;


use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceController
{
    public function index(string $resource)
    {
        $instance = $this->getResourceInstance($resource);
        if (!in_array('index', $instance->getEndpoints())) {
            throw new NotFoundHttpException('resource has no index endpoint');
        }

        return $instance->asResourceCollection($instance->newQuery()->paginate());
    }

    public function show(string $resource, int $id)
    {
        $instance = $this->getResourceInstance($resource);
        if (!in_array('show', $instance->getEndpoints())) {
            throw new NotFoundHttpException('resource has no show endpoint');
        }

        return $instance->asResource($instance->newQuery()->findOrFail($id));
    }

    public function delete(string $resource, int $id)
    {
        $instance = $this->getResourceInstance($resource);
        if (!in_array('delete', $instance->getEndpoints())) {
            throw new NotFoundHttpException('resource has no delete endpoint');
        }
        $model = $instance->newQuery()->findOrFail($id);
        $model->delete();

        return ['success' => true];
    }

    protected function getResourceInstance(string $resource): HasApiEndpoints
    {
        $resources = config('cms.resources');

        if (!array_key_exists($resource, $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        $resourceClass = $resources[$resource];
        $instance = new $resourceClass();

        if(!$instance instanceof HasApiEndpoints){
            throw new NotFoundHttpException('Resource does not implement HasApiEndpoints');
        }

        return $instance;
    }
}
