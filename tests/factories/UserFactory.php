<?php

/** @var Factory $factory */

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

$factory->define(User::class, function (Faker $faker) {
    $randomImgUrl = 'https://picsum.photos/300/300?random='.$faker->unique()->randomNumber(5, true);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password', // password
        'bio' => $faker->paragraphs(rand(1, 3), true),
        'avatar' => $randomImgUrl,
    ];
});
