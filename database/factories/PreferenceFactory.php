<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExamSession;
use App\Preference;
use App\Teacher;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    $groupsNames = [
        '2181', '2182', '2183', '2184', '2185', '2189', '2190',
        '2281', '2283', '2284', '2285',
        '2381', '2383', '2384'
    ];
    $roomsNames = [
        'AE', 'AN', 'AX',
        'L01', 'L02', 'L03', 'L20', 'L21', 'L22', 'L23', 'L24', 'L25', 'L26',
        'PV11', 'PV12', 'PV2', 'PV3', 'PV4', 'PV5', 'PV6', 'PV7', 'PV8',
    ];
    $values = [];
    for ($i = 1; $i <= $faker->numberBetween(1, 3); $i++) {
        $values[] = [
            'course_name' => $faker->realText(25),
            'groups' => implode(', ', $faker->randomElements($groupsNames, $faker->numberBetween(1, 4))),
            'type' => $faker->randomElement(['oral', 'written']),
            'room' => implode(', ', $faker->randomElements($roomsNames, $faker->numberBetween(1, 5))),
            'duration' => $faker->randomElement([2, 4, 8]),
            'watched_by' => Teacher::all()->random(1)->first()->name
        ];
    }

    return [
        'teacher_id' => Teacher::all()->random(1)->first()->id,
        'exam_session_id' => ExamSession::all()->random(1)->first()->id,
        'values' => json_encode($values),
        'state' => $faker->randomElement(['draft', 'published']),
    ];
});
