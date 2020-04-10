<?php

namespace Bambamboole\LaravelCms\Core\Users\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public function getGroup()
    {
        return strtok($this->name, '.');
    }
}
