<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\CheckboxField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Permissions\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoleForm extends Form
{

    /**
     * @var Model | \Bambamboole\LaravelCms\Core\Permissions\Models\Role
     */
    protected Model $resource;

    public function fields(): Collection
    {
        return Permission::all()->map(function ($permission) {
            return CheckboxField::make($permission->name, $permission->name)
                ->rules(['boolean'])
                ->addResolveValueCallback(function ($value) use ($permission) {

                    return $this->resource->hasPermissionTo($permission);
                });
        });
    }

    protected function updateResource($data)
    {
        $this->resource->updatePermissions(collect($data)
            ->filter() // remove all items with value == false
            ->keys() // remove all boolean values, just use permission strings
            ->transform(function ($item) { // transform all incorrect permission strings
                //todo: remove later. perhaps must be changed in general form implementation
                $item = str_replace('__asterisk__', '*', $item);
                $item = str_replace('->', '.', $item);

                return $item;
            })
        );
    }
}
