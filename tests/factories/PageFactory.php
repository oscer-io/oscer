<?php

/** @var Factory $factory */

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Publishing\Models\Page;
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
        'name' => $faker->name,
        'slug' => $faker->unique()->slug,
        'body' => $faker->paragraph,
        'author_id' => User::all()->random()->id,
        'published_at' => rand(0, 1) == 1 ? null : now()->subMonths(rand(1, 8))->subDays(rand(1, 20)),
    ];
});
