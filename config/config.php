<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'from_email' => env('CMS_FROM_EMAIL', 'cms@website.com'),
    'backend' => [
        'url' => 'admin',
        'middleware' => 'web',
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
