<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Permissions\Forms\RoleForm;
use Bambamboole\LaravelCms\Core\Permissions\Resources\RoleResource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Role extends \Spatie\Permission\Models\Role implements
    FormResource,
    HasApiEndpoints,
    HasIndexEndpoint,
    HasStoreEndpoint,
    HasShowEndpoint
{
    const SUPER_ADMIN_ROLE = 'super-admin';

    public function executeIndex()
    {
        return RoleResource::collection(self::all());
    }

    public function executeShow($identifier)
    {
        return new RoleResource(self::query()->findOrFail($identifier));
    }

    public function executeStore(Request $request)
    {
        $form = $this->getForm();
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model = $form->save();

        return $this->asResource($model);
    }

    public function getForm(): Form
    {
        return new RoleForm($this);
    }

    /**
     * @param $permissions
     */
    public function updatePermissions($permissions)
    {
        $this->syncPermissions($permissions);
    }

    /**
     * This method returns the FormResource for an update form.
     */
    public function findByIdentifier(string $identifier): FormResource
    {
        return $this->newQuery()->findOrFail($identifier);
    }

    /**
     * This method returns the resource after the save.
     *
     * @return Responsable|array
     */
    public function asApiResource()
    {
        return new RoleResource($this);
    }

    /**
     * This method determines is this will be a create or a update form.
     */
    public function isCreation(): bool
    {
        return $this->id === null;
    }
}
