<?php

namespace Oscer\Cms\Core\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    const SUPER_ADMIN_ROLE = 'super-admin';
}
