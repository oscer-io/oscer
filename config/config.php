<?php

/*
 * You can place your custom package configuration in here.
 */

use Oscer\Cms\Core\Menus\Resources\MenuItemResource;
use Oscer\Cms\Core\Menus\Resources\MenuResource;
use Oscer\Cms\Core\Options\Resources\OptionResource;
use Oscer\Cms\Core\Pages\Resources\PageResource;
use Oscer\Cms\Core\Posts\Resources\PostResource;
use Oscer\Cms\Core\Users\Resources\RoleResource;
use Oscer\Cms\Core\Users\Resources\UserResource;

return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'backend' => [
        'domain' => env('CMS_BACKEND_DOMAIN'),
        'url' => 'admin',
        'middleware' => 'web',
    ],
    'resources' => [
        'user' => UserResource::class,
        'role' => RoleResource::class,
        'post' => PostResource::class,
        'page' => PageResource::class,
        'menu' => MenuResource::class,
        'menu-item' => MenuItemResource::class,
        'option' => OptionResource::class,
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
