<?php

namespace App\Http\Controllers;

use App\Http\Requests\DraftExamSessionStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DraftExamSessionController extends Controller
{
    public function store(DraftExamSessionStoreRequest $request)
    {
        $id = request('id') ?? null;
        $data['location_id'] = request('location');
        if (request('title')) {
            $data['title'] = request('title');
            $data['slug'] = Str::slug(request('title'), '-');
        }
        $data['indications'] = request('indications');
        $data['deadline'] = request('deadline');
        $data['is_validated'] = false;

        $examSession = Auth::user()->examSessions()->updateOrCreate(
            ['id' => $id],
            $data
        );
        Session::flash('lastAction', ['type' => 'store', 'isDraft' => true, 'resource' => ['type' => 'examSession', 'value' => $examSession]]);
        Session::flash('notifications', ['Le brouillon a été enregistré']);
        return redirect()->route('exam_sessions.edit', ['exam_session' => $examSession->id]);
    }
}
