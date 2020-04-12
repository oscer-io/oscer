<?php

namespace Bambamboole\LaravelCms\Core\Users\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    public function getGroup()
    {
        return strtok($this->name, '.');
    }
}
