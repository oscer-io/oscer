<?php

namespace Bambamboole\LaravelCms\Core\Users\Forms;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Fields\CheckboxGroupField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Users\Models\Permission;
use Bambamboole\LaravelCms\Core\Users\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleForm extends Form
{
    /**
     * @var FormResource | \Bambamboole\LaravelCms\Core\Users\Models\Role
     */
    protected FormResource $resource;

    public function fields(): Collection
    {
        return collect(
            [
                CheckboxGroupField::make(
                    'permissions',
                    null,
                    null,
                    function (Role $resource, Request $request) {
                        $permissions = collect($request->input('permissions'))
                            ->filter(function ($permission) {
                                return $permission['value'] === true;
                            })
                            ->map(function ($permission) {
                                return $permission['name'];
                            });

                        $resource->syncPermissions($permissions);
                    })
                    ->fields(
                        Permission::all()
                            ->map(
                                function ($permission) {
                                    return [
                                        'name' => $permission->name,
                                        'label' => $permission->name,
                                        'value' => $this->resource->hasPermissionTo($permission),
                                    ];
                                }
                            )
                            ->toArray()
                    ),
            ]
        );
    }
}
