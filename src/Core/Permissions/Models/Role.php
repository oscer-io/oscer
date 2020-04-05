<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Permissions\Forms\RoleForm;
use Bambamboole\LaravelCms\Core\Permissions\Resources\RoleResource;

class Role extends \Spatie\Permission\Models\Role implements
    HasForm,
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint
{
    const SUPER_ADMIN_ROLE = 'super-admin';

    public function executeIndex()
    {
        return RoleResource::collection(self::all());
    }

    public function executeShow($identifier)
    {
        return new RoleResource(Role::query()->findOrFail($identifier));
    }

    public function getForm()
    {
        return new RoleForm($this);
    }
}
