<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\CheckboxField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Permissions\Models\Permission;
use Illuminate\Support\Collection;

class RoleForm extends Form
{
    public function fields(): Collection
    {
        $role = $this->resource;

        return Permission::all()->map(function ($permission) use ($role) {
            $value = $role->hasPermissionTo($permission);
            $field = CheckboxField::make($permission->name, $permission->name, true)->rules(['required', 'boolean']);
            $field->addResolveValueCallback(function ($field) use ($value) {
                return $value;//$rolePermissions->contains($permission);
            });
            return $field;
        });
    }
}
