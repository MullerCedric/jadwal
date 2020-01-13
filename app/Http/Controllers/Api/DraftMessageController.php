<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftExamSessionStoreRequest;
use App\User;
use Illuminate\Http\Request;

class DraftMessageController extends Controller
{
    public function store(DraftExamSessionStoreRequest $request)
    {
        $id = request('id') ?? null;
        $user = User::where('api_token', $_GET['api_token'])->firstOrFail();

        $data['exam_session_id'] = request('exam_session');
        if (request('title')) {
            $data['title'] = request('title');
        }
        $data['body'] = request('body');
        $data['is_validated'] = false;

        return $user->messages()->updateOrCreate(
            ['id' => $id],
            $data
        );
    }
}
