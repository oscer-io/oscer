<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This controller handles the form fetching and submitting.
 */
class ResourceFormController
{
    /**
     * Return the form definition based on a resource.
     * It will be a create form if "id" is null.
     */
    public function show($resource, $id = null)
    {
        return ['data' => $this->getForm($resource, $id)];
    }

    /**
     * This method will be called on form submission.
     */
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
        $resources = config('cms.resources');

        // Return a 404 response if the resource is not found
        if (! array_key_exists($resource, $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        $resourceClass = $resources[$resource];
        $instance = new $resourceClass();

        // Return a 404 response if the resource does not implement FormResource
        if (! $instance instanceof FormResource) {
            throw new NotFoundHttpException('Resource does not implement FormResource');
        }

        // Determine if this is a create or update form
        if ($id === null) {
            return $instance->getForm();
        } else {
            return $instance->findByIdentifier($id)->getForm();
        }
    }
}
