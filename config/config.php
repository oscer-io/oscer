<?php

/*
 * You can place your custom package configuration in here.
 */

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Menus\Models\Menu;
use Bambamboole\LaravelCms\Menus\Models\MenuItem;
use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Publishing\Models\Post;

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
        'option' => Option::class,
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
