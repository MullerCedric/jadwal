<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExamSession;
use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'exam_session_id' => ExamSession::all()->random(1)->first()->id,
        'title' => $faker->realText(55),
        'body' => $faker->paragraphs(3, true),
        'is_validated' => $faker->randomElement([true, false]),
    ];
});
