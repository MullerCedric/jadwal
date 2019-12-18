<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Teacher::class, function (Faker $faker) {
    $now = new DateTime();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'token' => Str::random(5) . '' . substr($now->getTimestamp(), -7) . '' . Str::random(4)
    ];
});
