<?php

/*
 * You can place your custom package configuration in here.
 */

use Bambamboole\LaravelCms\Core\Menus\Resources\MenuItemResource;
use Bambamboole\LaravelCms\Core\Menus\Resources\MenuResource;
use Bambamboole\LaravelCms\Core\Pages\Resources\PageResource;
use Bambamboole\LaravelCms\Core\Posts\Resources\PostResource;
use Bambamboole\LaravelCms\Core\Users\Resources\RoleResource;
use Bambamboole\LaravelCms\Core\Users\Resources\UserResource;

return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'backend' => [
        'domain' => env('CMS_BACKEND_DOMAIN'),
        'url' => 'admin',
        'middleware' => 'web',
    ],
    'resources'  => [
        'user'  => UserResource::class,
        'role' => RoleResource::class,
        'post' => PostResource::class,
        'page' => PageResource::class,
        'menu' => MenuResource::class,
        'menu-item' => MenuItemResource::class,
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
