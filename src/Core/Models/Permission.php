<?php

namespace Oscer\Cms\Core\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    public function getGroup()
    {
        // @TODO What is this?
        return strtok($this->name, '.');
    }
}
