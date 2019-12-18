<?php

use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Teacher::all()->each(function ($teacher) {
            $teacher->examSessions()->each(function ($examSession) use ($teacher) {
                if(!$examSession->is_validated) return;
                if (rand(0, 1) >= 1) {
                    $examSession->preferences()->save(factory(App\Preference::class)->make([
                        'teacher_id' => $teacher->id,
                        'exam_session_id' => $examSession->id
                    ]));
                }
            });
        });
    }
}
