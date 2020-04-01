<?php

use Bambamboole\LaravelCms\Permissions\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPermissions extends Migration
{
    const PERMISSIONS = [
        'posts.create.*',
        'posts.view.*',
        'posts.update.*',
        'posts.delete.*',
        'pages.create.*',
        'pages.view.*',
        'pages.update.*',
        'pages.delete.*',
        'menus.create.*',
        'menus.view.*',
        'menus.update.*',
        'menus.delete.*',
        'options.create.*',
        'options.view.*',
        'options.update.*',
        'options.delete.*',
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
        foreach (self::PERMISSIONS as $permission) {
            $parts = explode('.', $permission);
            $group = $parts[0];
            $crud = $parts[1] ?? null;
            $subGroup = $parts[2] ?? null;

            Permission::create(['name' => $permission, 'group' => $group, 'crud' => $crud, 'sub_group' => $subGroup]);
        }
    }
}
