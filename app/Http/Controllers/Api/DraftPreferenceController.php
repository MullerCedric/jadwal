<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftExamSessionStoreRequest;
use App\Preference;
use App\Teacher;
use Illuminate\Http\Request;

class DraftPreferenceController extends Controller
{
    public function store(DraftExamSessionStoreRequest $request)
    {
        $id = request('id') ?? null;
        $token = request('token') ?? null;
        if ($id) {
            $pref = Preference::with('teacher')->findOrFail($id);
            $teacher = $pref->teacher;
        } else {
            $teacher = Teacher::where('token', $token)->firstOrFail();
        }

        $values = [];
        for ($i = 0; request('count' . $i) == 'true'; $i++) {
            if (request('course_name' . $i) ||
                request('groups' . $i) ||
                request('groups_indications' . $i) ||
                request('rooms' . $i) ||
                request('duration' . $i) ||
                request('watched_by' . $i)
            ) {
                $validatedData = $request->validate([
                    ('course_name' . $i) => 'nullable|string',
                    ('groups' . $i) => 'nullable|string',
                    ('groups_indications' . $i) => 'nullable|string',
                    ('type' . $i) => 'nullable|string',
                    ('rooms' . $i) => 'nullable|string',
                    ('duration' . $i) => 'nullable|integer|min:1',
                    ('watched_by' . $i) => 'nullable|string',
                ]);

                $values[] = [
                    'course_name' => $validatedData['course_name' . $i] ?? null,
                    'groups' => $validatedData['groups' . $i] ?? null,
                    'groups_indications' => $validatedData['groups_indications' . $i] ?? null,
                    'type' => $validatedData['type' . $i] ?? null,
                    'rooms' => $validatedData['rooms' . $i] ?? null,
                    'duration' => $validatedData['duration' . $i] ?? null,
                    'watched_by' => $validatedData['watched_by' . $i] ?? null,
                ];
            }
        }


        $preference = Preference::updateOrCreate(
            ['id' => $id],
            [
                'teacher_id' => $teacher->id,
                'exam_session_id' => request('exam_session'),
                'values' => $values ? json_encode($values) : null,
                'about' => request('about'),
                'is_validated' => false,
            ]
        );
    }
}
