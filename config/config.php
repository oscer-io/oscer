<?php

/*
 * You can place your custom package configuration in here.
 */

use Bambamboole\LaravelCms\Themes\DefaultTheme;

return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'database_connection' => env('CMS_DB_CONNECTION', 'cms'),
    'backend' => [
        'url' => 'admin',
        'middleware' => 'web',
    ],
    'menus' => [
        'main' => [],
        'footer' => [],
    ],
    'theme' => DefaultTheme::class,
    'blog' => [
        'middleware' => 'web',
    ],
    'pages' => [
        'middleware' => 'web',
    ],
];
