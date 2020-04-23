<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Oscer\Cms\Core\Menus\Models\MenuItem;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(MenuItem::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'menu' => 'main',
        'url' => $faker->url,
        'order' => 1,
    ];
});
