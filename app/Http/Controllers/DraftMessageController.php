<?php

namespace App\Http\Controllers;

use App\Http\Requests\DraftMessageStoreRequest;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DraftMessageController extends Controller
{
    public function store(DraftMessageStoreRequest $request)
    {
        $id = request('id') ?? null;
        $message = Auth::user()->messages()->updateOrCreate(
            ['id' => $id],
            [
                'exam_session_id' => request('exam_session'),
                'title' => request('title'),
                'body' => request('body'),
                'is_validated' => false,
            ]
        );
        Session::flash('lastAction', ['type' => 'store', 'isDraft' => true, 'resource' => ['type' => 'message', 'value' => $message]]);
        Session::flash('notifications', ['Le brouillon a été enregistré']);
        return redirect()->route('messages.edit', ['message' => $message->id]);
    }
}
