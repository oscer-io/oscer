<?php

use Bambamboole\LaravelCms\Permission\Models\Permission;
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
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::PERMISSIONS as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
