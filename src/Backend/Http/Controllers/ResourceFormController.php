<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceFormController
{
    public function show($resource, $id = null)
    {
        return $this->getForm($resource, $id);
    }

    public function store(Request $request, $resource, $id = null)
    {
        $form = $this->getForm($resource, $id);
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resource = $form->save();

        return response()->json(['data' => $resource])->setStatusCode($resource->wasRecentlyCreated ? 201 : 200);
    }

    protected function getForm($resource, $id): Form
    {
        $instance = $this->getResourceInstance($resource);
        if ($id === null) {
            return $instance->getForm();
        } else {
            return $instance->newQuery()->findOrFail($id)->getForm();
        }
    }

    protected function getResourceInstance(string $resource): HasForm
    {
        $resources = config('cms.resources');

        if (! array_key_exists($resource, $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        $resourceClass = $resources[$resource];
        $instance = new $resourceClass();

        if (! $instance instanceof HasForm) {
            throw new NotFoundHttpException('Resource does not implement HasForm');
        }

        return $instance;
    }
}
