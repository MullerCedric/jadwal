<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\ExamSession;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ExamSession::class, function (Faker $faker) {
    setlocale (LC_TIME, app()->getLocale());

    $now = new DateTime();
    $deadline = $faker->dateTimeBetween('now', '+ 5 months');
    $sent_at = $faker->dateTimeBetween('- 2 months', $deadline);

    $title = 'Session d\'examens de ' . utf8_encode(strftime('%B %Y', $deadline->getTimestamp()));
    $slug = Str::slug($title, '-');

    return [
        'user_id' => User::all()->random(1)->first()->id,
        'location_id' => Location::all()->random(1)->first()->id,
        'title' => $title,
        'slug' => $slug,
        'indications' => $faker->realText(100) . "\xA" . $faker->realText(100),
        'deadline' => $deadline,
        'is_validated' => $sent_at <= $now ? true : false,
        'sent_at' => $sent_at <= $now ? $sent_at : null,
    ];
});
