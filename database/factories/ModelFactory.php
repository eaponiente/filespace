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
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => 'admin',
        'password' => bcrypt(123456),
        'key_code' => str_random(7)
        'remember_token' => str_random(10),
    ];
});
