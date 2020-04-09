<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceFormController
{
    public function show($resource, $id = null)
    {
        return ['data' => $this->getForm($resource, $id)];
    }

    public function store(Request $request, $resource, $id = null)
    {
        $form = $this->getForm($resource, $id);

        try {
            $resource = $form->save($request);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }

        return $resource->asApiResource();
    }

    protected function getForm($resource, $id): Form
    {
        $instance = $this->getResourceInstance($resource);

        if ($id === null) {
            return $instance->getForm();
        } else {
            return $instance->findByIdentifier($id)->getForm();
        }
    }

    protected function getResourceInstance(string $resource): FormResource
    {
        $resources = config('cms.resources');

        if (!array_key_exists($resource, $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        $resourceClass = $resources[$resource];
        $instance = new $resourceClass();

        if (!$instance instanceof FormResource) {
            throw new NotFoundHttpException('Resource does not implement Resource');
        }

        return $instance;
    }
}
