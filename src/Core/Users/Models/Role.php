<?php

namespace Bambamboole\LaravelCms\Core\Users\Models;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Backend\Resources\IsSavableEloquentModel;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole implements SavableModel
{
    use IsSavableEloquentModel;

    const SUPER_ADMIN_ROLE = 'super-admin';
}
