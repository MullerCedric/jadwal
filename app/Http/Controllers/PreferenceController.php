<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\PreferenceCopyRequest;
use App\Http\Requests\PreferenceStoreRequest;
use App\Jobs\PreferenceModifiedJob;
use App\Preference;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PreferenceController extends Controller
{
    public function index($token)
    {
        $teacher = Teacher::with('locations')->where('token', $token)->firstOrFail();
        $teachersExamSessions = $this->getEmptySession($teacher, 15);
        $emptyExamSessions = $this->getEmptySession($teacher);
        return view('preferences.index', compact('teacher', 'teachersExamSessions', 'emptyExamSessions', 'token'));
    }

    public function create($token, ExamSession $examSession)
    {
        $examSession->load('location');
        $teacher = Teacher::with([
            'preferences' => function ($query) {
                $query->where('is_validated', true)
                    ->orderBy('updated_at', 'desc')
                    ->whereNotNull('sent_at');
            }
        ])
            ->where('token', $token)->firstOrFail();
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
                    ('duration' . $i) => 'required|integer|min:1|max:8',
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

        if ($preference->sent_at) {
            $username = strval(auth()->user()->name);
            dispatch(new PreferenceModifiedJob($preference, $username));
        }

        Session::flash('lastAction', ['type' => 'store', 'isDraft' => false, 'resource' => ['type' => 'preference', 'value' => $preference]]);
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
        $emptyExamSessions = $this->getEmptySession($teacher);
        return view('preferences.show', compact('preference', 'examSession', 'teacher', 'emptyExamSessions', 'token'));
    }

    public function showPDF(Preference $preference, $token = null)
    {
        $preference->load('examSession');
        $fileName = 'preferences-';
        $fileName .= Str::slug($preference->teacher->name, '-');
        $fileName .= '-' . $preference->examSession->slug . '.pdf';

        return (new PdfController())->preferenceToPDF($preference)->download($fileName);
    }

    public function edit(Preference $preference, $token = null)
    {
        $preference->load([
            'teacher',
            'examSession' => function ($query) {
                $query->withTrashed();
            }
        ]);
        $examSession = $preference->examSession;
        $examSession->load('location');
        if ($token && $preference->teacher->token !== $token) { // TODO put this on a gate
            return 'Vous n\'êtes pas ' . $preference->teacher->name . ' ! Vous n\'avez donc pas accès à ces préférences';
        }
        $teacher = $preference->teacher;
        $teacher->load([
            'preferences' => function ($query) {
                $query->where('is_validated', true)
                    ->orderBy('updated_at', 'desc')
                    ->whereNotNull('sent_at');
            }
        ]);
        return view('preferences.edit', compact('preference', 'examSession', 'teacher', 'token'));
    }

    public function copy(PreferenceCopyRequest $request, $token, Preference $preference)
    {
        $examSession = ExamSession::findOrFail(request('targeted_exam_session'));
        $teacher = Teacher::where('token', $token)->firstOrFail();

        $newPreference = Preference::updateOrCreate(
            [
                'teacher_id' => $teacher->id,
                'exam_session_id' => request('targeted_exam_session'),
            ],
            [
                'values' => json_encode($preference->values),
                'about' => $preference->about,
                'is_validated' => false,
            ]
        );

        Session::flash('lastAction', ['type' => 'copy', 'isDraft' => true, 'resource' => ['type' => 'preference', 'value' => $preference]]);
        Session::flash('notifications', ['Vos anciennes préférences ont bien été copiées pour <i>' . $examSession->title . '</i> en cours']);
        return redirect()->route('preferences.edit', ['preference' => $newPreference->id, 'token' => $token]);
    }

    protected function getEmptySession($teacher, $paginate = false)
    {
        $sessions = ExamSession::withTrashed()->with([
            'location',
            'preferences' => function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            }])
            ->whereHas('location', function ($query) use ($teacher) {
                foreach ($teacher->locations as $index => $location) {
                    if ($index === 0) {
                        $query->where('id', $location->id);
                    } else {
                        $query->orWhere('id', $location->id);
                    }
                }
            })
            ->whereNotNull('sent_at')
            ->orderBy('deadline', 'asc');
        if ($paginate && is_int($paginate) && $paginate > 0) {
            $sessions = $sessions->paginate($paginate);
        } else {
            $sessions = $sessions->get();
        }
        return $sessions;
    }
}
