<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'token' => $faker->password . '' . $faker->password
    ];
});
