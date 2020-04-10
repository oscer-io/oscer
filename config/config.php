<?php

/*
 * You can place your custom package configuration in here.
 */

use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;
use Bambamboole\LaravelCms\Core\Options\Models\Option;
use Bambamboole\LaravelCms\Core\Pages\Models\Page;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Core\Users\Models\Permission;
use Bambamboole\LaravelCms\Core\Users\Models\Role;
use Bambamboole\LaravelCms\Core\Users\Models\User;

return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'backend' => [
        'domain' => env('CMS_BACKEND_DOMAIN'),
        'url' => 'admin',
        'middleware' => 'web',
    ],
    'resources' => [
        'user' => User::class,
        'menu' => Menu::class,
        'menu-item' => MenuItem::class,
        'post' => Post::class,
        'page' => Page::class,
        'option' => Option::class,
        'role' => Role::class,
        'permission' => Permission::class,
    ],
    'options' => [
        'pages' => [
            'front_page' => [
                'label' => 'Frontpage Slug',
                'type' => 'text',
            ],
        ],
    ],
];
