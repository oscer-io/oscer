<?php

namespace Oscer\Cms\Backend\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    /**
     * Retrieves the resource class name based on the route parameter.
     */
    public function getResource(): string
    {
        $resources = config('cms.resources');

        // Return a 404 response if the resource is not found
        if (! array_key_exists($this->route('resource'), $resources)) {
            throw new NotFoundHttpException('resource not found');
        }

        return $resources[$this->route('resource')];
    }

    /**
     * Returns the string representation of the underlying model.
     */
    public function getResourceModel(): string
    {
        $resource = $this->getResource();

        return $resource::$model;
    }

    /**
     * Creates a new instance of the underlying model.
     */
    public function newResourceModel(): Model
    {
        $model = $this->getResourceModel();

        return new $model();
    }

    public function identifier()
    {
        return $this->route('id');
    }
}
