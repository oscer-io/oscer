<?php

namespace Bambamboole\LaravelCms\Core\Users\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\CheckboxGroupField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Users\Models\Permission;
use Bambamboole\LaravelCms\Core\Users\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleResource extends Resource
{
    public static string $model = Role::class;

    public function fields(): Collection
    {
        return collect(
            [
                TextField::make('name'),
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
                                        'value' => $this->resourceModel->hasPermissionTo($permission),
                                    ];
                                }
                            )
                            ->toArray()
                    ),
            ]
        );
    }
}
