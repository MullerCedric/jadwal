<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\ExamSessionCopyRequest;
use App\Http\Requests\ExamSessionStoreRequest;
use App\Location;
use App\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
            $examSession->location->sentTeachers = $examSession->location->teachers->reduce(function ($carry, $item) {
                if ($item->preferences_are_sent) {
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
        $notifications = [];
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
        Session::flash('lastAction', ['type' => 'store', 'isDraft' => false, 'resource' => ['type' => 'examSession', 'value' => $examSession]]);
        $notifications[] = 'La session a été enregistrée';

        if ($examSession->messages()->get()->isEmpty()) {
            $notifications[] = 'Vous pouvez maintenant y associer un message';
            Session::flash('notifications', $notifications);
            return redirect()->route('messages.create');
        }

        Session::flash('notifications', $notifications);
        return redirect()->route('exam_sessions.show', ['id' => $examSession->id]);
    }

    public function show($id)
    {
        $examSession = ExamSession::withTrashed()
            ->with([
                'messages',
                'location',
                'location.teachers' => function ($query) {
                    $query->orderBy('name', 'asc');
                }
            ])
            ->findOrFail($id);
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
                $q->where('exam_session_id', "=", $examSession->id)->whereNotNull('sent_at');
            },
            'preferences as preferences_are_draft' => function ($q) use ($examSession) {
                $q->where('exam_session_id', "=", $examSession->id)->whereNull('sent_at');
            },
        ]);
        $today = Carbon::now();
        return view('exam_sessions.show', compact('examSession', 'today'));
    }

    public function edit(ExamSession $examSession)
    {
        $locations = Location::all();
        $today = Carbon::now();
        return view('exam_sessions.edit', compact('examSession', 'locations', 'today'));
    }

    public function copy(ExamSessionCopyRequest $request, $id)
    {
        $examSession = ExamSession::withTrashed()->with('messages')->findOrFail($id);

        $newExamSession = new ExamSession();
        $newExamSession->location_id = $examSession->location_id;
        $newExamSession->title = $examSession->title . ' - copie';
        $newExamSession->slug = $examSession->slug . '-copie';
        $newExamSession->indications = $examSession->indications;
        $newExamSession->deadline = $examSession->deadline;
        $newExamSession->is_validated = false;
        $newExamSession->sent_at = null;
        Auth::user()->examSessions()->save($newExamSession);

        if (request('keep_message')) {
            foreach ($examSession->messages as $message) {
                $newMessage = new Message();
                $newMessage->title = $message->title . ' - copie';
                $newMessage->body = $message->body;
                $newMessage->is_validated = false;
                $newMessage->sent_at = null;
                $newExamSession->messages()->save($newMessage);
            }
        }

        Session::flash('lastAction', ['type' => 'copy', 'isDraft' => true, 'resource' => ['type' => 'examSession', 'value' => $newExamSession]]);
        Session::flash('notifications', ['<i>' . $examSession->title . '</i> a bien été copié']);
        return redirect()->route('exam_sessions.edit', ['exam_session' => $newExamSession->id]);
    }
}
