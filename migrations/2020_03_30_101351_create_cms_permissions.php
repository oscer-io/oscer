<?php

use Bambamboole\LaravelCms\Permissions\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPermissions extends Migration
{
    protected array $permissions = [
        'posts.*', // all permissions in posts
        'posts.view',
        'posts.create',
        'posts.update',
        'posts.delete',
        'pages.*', // all permissions in pages
        'pages.view',
        'pages.create',
        'pages.update',
        'pages.delete',
        'menus.*', // all permissions in menus
        'menus.change-order',
        'menus.view',
        'menus.view_items',
        'menus.create_items',
        'menus.update_items',
        'menus.delete_items',
        'options.*', // all permissions in options
        'options.view',
        'options.update',
        'users.*',  // all permissions in users
        'users.view',
        'users.create',
        'users.update',
        'users.delete',
        'roles.*', // all permissions in roles
        'roles.view',
        'roles.create',
        'roles.update',
        'roles.delete',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
