<?php

namespace Bambamboole\LaravelCms\Permissions\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public function getGroup()
    {
        return strtok($this->name, '.');
    }
}
