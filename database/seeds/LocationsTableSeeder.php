<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Since the factory check for existence, we need to call it several times manually
        for ($i = 0; $i < 3; $i++) {
            factory(App\Location::class, 1)->create();
        }
    }
}
