<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DraftExamSessionStoreRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DraftExamSessionController extends Controller
{
    public function store(DraftExamSessionStoreRequest $request)
    {
        $id = request('id') ?? null;
        $user = User::where('api_token', $_GET['api_token'])->firstOrFail();

        $data['location_id'] = request('location');
        if (request('title')) {
            $data['title'] = request('title');
            $data['slug'] = Str::slug(request('title'), '-');
        }
        $data['indications'] = request('indications');
        $data['deadline'] = request('deadline');
        $data['is_validated'] = false;

        return $user->examSessions()->updateOrCreate(
            ['id' => $id],
            $data
        );
    }
}
