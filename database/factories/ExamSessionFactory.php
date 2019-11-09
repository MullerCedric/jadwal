<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\ExamSession;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ExamSession::class, function (Faker $faker) {
    $title = $faker->sentence;
    $slug = Str::slug($title, '-');
    return [
        'user_id' => User::all()->random(1)->first()->id,
        'location_id' => Location::all()->random(1)->first()->id,
        'title' => $title,
        'slug' => $slug,
        'indications' => '<p>' . $faker->realText(100) . '</p><p>' . $faker->realText(100) . '</p>',
        'deadline' => $faker->dateTimeBetween('-3 months', '+ 1 year'),
        'state' => $faker->randomElement(['draft', 'published']),
    ];
});
