<?php

/** @var Factory $factory */

use Bambamboole\LaravelCms\Models\Page;
use Bambamboole\LaravelCms\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

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

$factory->define(Page::class, function (Faker $faker) {
    return [
        'author_id' => factory(User::class),
        'name' => $faker->name,
        'slug' => $faker->unique()->slug,
        'body' => $faker->randomLetter,
    ];
});
