<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(LocationsTeachersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(PreferencesTableSeeder::class);
    }
}
