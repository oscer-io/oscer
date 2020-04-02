<?php

use Bambamboole\LaravelCms\Permissions\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPermissions extends Migration
{
    protected array $permissions = [
        'posts.create.*',
        'posts.view.*',
        'posts.update.*',
        'posts.delete.*',
        'pages.create.*',
        'pages.view.*',
        'pages.update.*',
        'pages.delete.*',
        'menus.view.*',
        'menus.items.create.*',
        'menus.items.view.*',
        'menus.items.update.*',
        'menus.items.delete.*',
        'options.view.*',
        'options.update.*',
        'users.create.*',
        'users.view.*',
        'users.update.*',
        'users.delete.*',
        'roles.create.*',
        'roles.view.*',
        'roles.update.*',
        'roles.delete.*',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $parts = explode('.', $permission);
            $group = $parts[0];
            $crud = $parts[1] ?? null;
            $subGroup = $parts[2] ?? null;

            Permission::create(['name' => $permission, 'group' => $group, 'crud' => $crud, 'sub_group' => $subGroup]);
        }
    }
}
