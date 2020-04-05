<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Core\Permissions\Resources\RoleResource;

class Role extends \Spatie\Permission\Models\Role implements
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint
{
    const SUPER_ADMIN_ROLE = 'super-admin';

    public function executeIndex()
    {
        return RoleResource::collection(self::all());
//        return ['data' => self::all()];
    }

    public function executeShow($identifier)
    {
        return new RoleResource(self::query()->findOrFail($identifier));
    }
}
