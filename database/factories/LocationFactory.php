<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    $locationsNames = [
        'Marêts', 'Campus agronomique', 'Campus 2000', 'Gloesener', 'Verviers', 'Beeckman', 'Barbou', 'Delchambre', 'Bld d\'Avroy'
    ];

    // Loop until it finds a name from the array that is not already in the database (with limited attempts)
    $nbAttempts = 0;
    $maxAttempts = 10;
    do {
        $locationName = $faker->randomElement($locationsNames);
        $exists = Location::where('name', '=', $locationName)->exists();
        $nbAttempts++;
    } while ($exists && $nbAttempts < $maxAttempts);

    // If we could not find something uniques after 10 attempts, we generate a city name
    if ($nbAttempts >= $maxAttempts) {
        $locationName = $faker->city;
    }

    return [
        'name' => $locationName,
    ];
});
