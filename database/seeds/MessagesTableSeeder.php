<?php

use App\ExamSession;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamSession::all()->each(function ($examSession) {
            for ($i = 1; $i <= rand(0, 2); $i++) {
                $examSession->messages()->save(factory(App\Message::class)->make());
            }
        });
    }
}
