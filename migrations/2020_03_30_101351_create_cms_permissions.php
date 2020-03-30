<?php

use Bambamboole\LaravelCms\Permission\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPermissions extends Migration
{

    const PERMISSIONS = [
        'posts.create',
        'posts.create.*',
        'posts.read.*',
        'posts.update.*',
        'posts.delete.*',
        'pages.create',
        'pages.create.*',
        'pages.read.*',
        'pages.update.*',
        'pages.delete.*',
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
