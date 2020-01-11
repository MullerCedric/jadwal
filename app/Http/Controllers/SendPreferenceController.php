<?php

namespace App\Http\Controllers;

use App\Jobs\PreferenceCreatedJob;
use App\Preference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SendPreferenceController extends Controller
{
    public function send(Preference $preference, $token = null)
    {
        $preference->load('teacher', 'examSession');
        $preference->sent_at = Carbon::now();

        $job = new PreferenceCreatedJob($preference);
        dispatch($job);

        $preference->save();

        Session::flash('notifications', ['Vos préférences ont été envoyées']);
        return redirect()->route('preferences.show', ['preference' => $preference->id, 'token' => $token]);
    }
}
