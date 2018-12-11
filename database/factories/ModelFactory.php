<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => 'Marcelo Buratti de Freitas',
        'email' => 'mfreitas@1500fh.com',
        'password' => bcrypt('123456'),
        'password' => bcrypt('123456'),
        'nivelacesso' => 1,
    ];
});
