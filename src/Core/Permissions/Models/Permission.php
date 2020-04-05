<?php

namespace Bambamboole\LaravelCms\Core\Permissions\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Core\Permissions\Resources\PermissionResource;

class Permission extends \Spatie\Permission\Models\Permission implements
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint
{
    public function getGroup()
    {
        return strtok($this->name, '.');
    }

    public function executeIndex()
    {
        return PermissionResource::collection(self::all());
    }

    public function executeShow($identifier)
    {
        // TODO: Implement executeShow() method.
    }
}
