<?php

namespace App\Http\Controllers;

use App\Http\Requests\DraftMessageStoreRequest;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DraftMessageController extends Controller
{
    public function store(DraftMessageStoreRequest $request)
    {
        $id = request('id') ?? null;
        $message = Message::updateOrCreate(
            ['id' => $id],
            [
                'exam_session_id' => request('exam_session'),
                'title' => request('title'),
                'body' => request('body'),
                'is_validated' => false,
            ]
        );
        Session::flash('notifications', ['Le brouillon a été enregistré']);
        return redirect()->route('messages.edit', ['message' => $message->id]);
    }
}
