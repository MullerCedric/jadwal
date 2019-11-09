<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Cédric Jadwal',
            'email' => 'cedric@jadwal.be',
            'password' => Hash::make('password')
        ]);
        factory(User::class, 3)->create();

        User::all()->each(function ($user) {
            $createExamSession = ($user->id == 1 || rand(0, 2) > 1);
            if ($createExamSession) {
                for ($i = 1; $i <= rand(1, 3); $i++) {
                    $user->examSessions()->save(factory(App\ExamSession::class)->make());
                }
            }
        });
    }
}
