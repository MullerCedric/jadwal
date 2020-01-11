<?php

namespace App\Http\Controllers;

use App\Jobs\PreferenceCreatedJob;
use App\Mail\PreferenceCreated;
use App\Preference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendPreferenceController extends Controller
{
    public function send(Preference $preference, $token = null)
    {
        $preference->sent_at = Carbon::now();
        $preference->save();

        dispatch((new PreferenceCreatedJob($preference->teacher)));

        /*Mail::to($preference->teacher)
            ->send(new PreferenceCreated());*/

        Session::flash('notifications', ['Vos préférences ont été envoyées']);
        return redirect()->route('preferences.show', ['preference' => $preference->id, 'token' => $token]);
    }
}
