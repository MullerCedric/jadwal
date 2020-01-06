<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\ExamSessionStoreRequest;
use App\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ExamSessionController extends Controller
{
    public function index()
    {
        $examSessions = Auth::user()
            ->examSessions()
            ->with([
                'location',
                'location.teachers'
            ])
            ->withCount([
                'preferences as sent_preferences_count' => function ($q) {
                    $q->where('is_validated', '=', true)->whereNotNull('sent_at');
                },
            ])
            ->orderBy('deadline', 'asc')
            ->orderBy('is_validated', 'desc')
            ->orderBy('sent_at', 'asc')
            ->paginate(5);
        $examSessions->each(function ($examSession) {
            $examSession->location->teachers->loadCount([
                'preferences as preferences_are_sent' => function ($q) use ($examSession) {
                    $q->where('exam_session_id', "=", $examSession->id)->where('is_validated', '=', true)->whereNotNull('sent_at');
                },
            ]);
            $examSession->location->sentTeachers = $examSession->location->teachers->reduce(function($carry, $item) {
                if($item->preferences_are_sent) {
                    $carry[] = $item;
                }
                return $carry;
            }, collect([]));
        });
        $today = Carbon::now();
        $currentTab = 'opened';
        return view('exam_sessions.index', compact('examSessions', 'today', 'currentTab'));
    }

    public function create()
    {
        $locations = Location::orderBy('updated_at', 'desc')->get();
        return view('exam_sessions.create', compact('locations'));
    }

    public function store(ExamSessionStoreRequest $request)
    {
        $id = request('id') ?? null;
        $examSession = Auth::user()->examSessions()->updateOrCreate(
            ['id' => $id],
            [
                'location_id' => request('location'),
                'title' => request('title'),
                'slug' => Str::slug(request('title'), '-'),
                'indications' => request('indications'),
                'deadline' => request('deadline'),
                'is_validated' => true,
            ]
        );
        Session::flash('notifications', ['La session a été enregistrée', 'Vous pouvez maintenant y associer un message']);
        Session::flash('payload', $examSession->id);
        return redirect()->route('messages.create');
    }

    public function show(ExamSession $examSession)
    {
        $examSession->load([
            'messages',
            'location',
            'location.teachers']);
        $examSession->loadCount([
            'preferences as sent_preferences_count' => function ($q) {
                $q->where('is_validated', '=', true)->whereNotNull('sent_at');
            }
        ]);
        $examSession->location->teachers->load([
            'preferences' => function ($query) use ($examSession) {
                $query->where('exam_session_id', '=', $examSession->id);
            },
        ]);
        $examSession->location->teachers->loadCount([
            'preferences as preferences_are_sent' => function ($q) use ($examSession) {
                $q->where('exam_session_id', "=", $examSession->id)->where('is_validated', '=', true)->whereNotNull('sent_at');
            },
            'preferences as preferences_are_draft' => function ($q) use ($examSession) {
                $q->where('exam_session_id', "=", $examSession->id)->where('is_validated', '=', false);
            },
        ]);
        $today = Carbon::now();
        return view('exam_sessions.show', compact('examSession', 'today'));
    }

    public function edit(ExamSession $examSession)
    {
        $locations = Location::all();
        return view('exam_sessions.edit', compact('examSession', 'locations'));
    }
}
