<?php

namespace Oscer\Cms\Core\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\CheckboxGroupField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Users\Models\Permission;
use Oscer\Cms\Core\Users\Models\Role;

class RoleResource extends Resource
{
    public static string $model = Role::class;

    protected bool $displayEditButtonOnIndex = false;

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

    protected function hasDetailView(): bool
    {
        return false;
    }
}
