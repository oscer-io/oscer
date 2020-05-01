<?php

/*
 * You can place your custom package configuration in here.
 */

use Oscer\Cms\Backend\Resources\MenuItemResource;
use Oscer\Cms\Backend\Resources\MenuResource;
use Oscer\Cms\Backend\Resources\OptionResource;
use Oscer\Cms\Backend\Resources\PageResource;
use Oscer\Cms\Backend\Resources\PostResource;
use Oscer\Cms\Backend\Resources\RoleResource;
use Oscer\Cms\Backend\Resources\UserResource;

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
