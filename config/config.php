<?php

/*
 * You can place your custom package configuration in here.
 */

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Menus\Models\MenuItem;

return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'backend' => [
        'domain' => env('CMS_BACKEND_DOMAIN'),
        'url' => 'admin',
        'middleware' => 'web',
    ],
    'resources' => [
      'user' => User::class,
      'menu-item' => MenuItem::class,
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
