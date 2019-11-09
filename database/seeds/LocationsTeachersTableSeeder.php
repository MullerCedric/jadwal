<?php

use Illuminate\Database\Seeder;

class LocationsTeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = App\Location::all();

        App\Teacher::all()->each(function ($teacher) use ($locations) {
            $teacher->locations()->attach(
                $locations->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
