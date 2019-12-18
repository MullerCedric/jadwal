<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\PreferenceStoreRequest;
use App\Preference;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreferenceController extends Controller
{
    public function index($token)
    {

    }

    public function create($token, ExamSession $examSession)
    {
        $examSession->load('location');
        $teacher = Teacher::where('token', $token)->firstOrFail();
        return view('preferences.create', compact('examSession', 'teacher', 'token'));
    }

    public function store(PreferenceStoreRequest $request)
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
                    ('course_name' . $i) => 'required|string',
                    ('groups' . $i) => 'required|string',
                    ('groups_indications' . $i) => 'nullable|string',
                    ('type' . $i) => 'required|in:oral,written',
                    ('rooms' . $i) => 'nullable|string',
                    ('duration' . $i) => 'required|integer|min:0|max:8',
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
                'values' => json_encode($values),
                'about' => request('about'),
                'is_validated' => true,
            ]
        );
        Session::flash('notifications', ['Vos préférences ont bien été enregistrées et envoyées']);
        return redirect()->route('preferences.show', ['preference' => $preference->id, 'token' => $token]);
    }

    public function show(Preference $preference, $token = null)
    {
        $preference->load([
            'teacher',
            'examSession'
        ]);
        $examSession = $preference->examSession;
        $examSession->load('location');
        if ($token && $preference->teacher->token !== $token) { // TODO put this on a gate
            return 'Vous n\'êtes pas ' . $preference->teacher->name . ' ! Vous n\'avez donc pas accès à ces préférences';
        }
        $teacher = $preference->teacher;
        return view('preferences.show', compact('preference', 'examSession', 'teacher', 'token'));
    }

    public function edit(Preference $preference, $token = null)
    {
        $preference->load([
            'teacher',
            'examSession'
        ]);
        $examSession = $preference->examSession;
        $examSession->load('location');
        if ($token && $preference->teacher->token !== $token) { // TODO put this on a gate
            return 'Vous n\'êtes pas ' . $preference->teacher->name . ' ! Vous n\'avez donc pas accès à ces préférences';
        }
        $teacher = $preference->teacher;
        return view('preferences.edit', compact('preference', 'examSession', 'teacher', 'token'));
    }
}
