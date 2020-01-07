<?php

namespace App\Http\Controllers;

use App\ExamSession;
use App\Http\Requests\MessageStoreRequest;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['examSession', 'examSession.location'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        $examSessions = Auth::user()
            ->examSessions()
            ->with('location')
            ->orderBy('updated_at', 'desc')->get();
        return view('messages.create', compact('examSessions'));
    }

    public function store(MessageStoreRequest $request)
    {
        $id = request('id') ?? null;
        $message = Message::updateOrCreate(
            ['id' => $id],
            [
                'exam_session_id' => request('exam_session'),
                'title' => request('title'),
                'body' => request('body'),
                'is_validated' => true,
            ]
        );
        Session::flash('notifications', ['Le message a été enregistré', 'Vous pouvez maintenant envoyer les formulaires aux professeurs concernés']);
        return redirect()->route('messages.show', ['message' => $message->id]);
    }

    public function show(Message $message)
    {
        $message->load(['examSession', 'examSession.location', 'examSession.location.teachers']);
        return view('messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        $email = $message; // renaming to avoid conflict with Laravel's variables
        $examSessions = ExamSession::with('location')->get();
        return view('messages.edit', compact('email', 'examSessions'));
    }

    public function destroy(Message $message)
    {
        $title = $message->title;
        $message->delete();
        Session::flash('notifications', ['Le message "' . $title . '"" a été définitivement supprimé']);
        return redirect()->route((isset($_GET['redirect_to']) && Route::has($_GET['redirect_to'])) ? $_GET['redirect_to'] : 'messages.index' );
    }
}
