<?php

/** @var Factory $factory */

use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Core\Users\Models\User;
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

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => $faker->words(rand(2, 6), true),
        'type' => 'post',
        'body' => $faker->paragraphs(rand(3, 7), true),
        'author_id' => rand(1, User::query()->count()),
        'published_at' => rand(0, 1) == 1 ? null : now()->subMonths(rand(1, 8))->subDays(rand(1, 20)),
    ];
});
