<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\SendForms;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendMessageController extends Controller
{
    public function send(Message $message)
    {
        $message->load(['examSession', 'examSession.location', 'examSession.location.teachers']);
        $examSession = $message->examSession;
        $message->examSession->location->teachers->loadCount([
            'preferences as preferences_are_sent' => function ($q) use ($examSession) {
                $q->where('exam_session_id', "=", $examSession->id)->where('is_validated', '=', true)->whereNotNull('sent_at');
            },
            'preferences as preferences_are_draft' => function ($q) use ($examSession) {
                $q->where('exam_session_id', "=", $examSession->id)->where('is_validated', '=', false);
            },
        ]);
        $email = $message; // renaming to avoid conflict with Laravel's variables

        $sent_at = Carbon::now();
        $message->sent_at = $sent_at;
        $message->save();
        $examSession->sent_at = $sent_at;
        $examSession->save();

        $sent_at->addSeconds(3);
        foreach ($email->examSession->location->teachers as $teacher) {
            if(!$teacher->preferences_are_sent) {
                dispatch(
                    (new SendEmailJob($email, $teacher))->delay($sent_at)
                );
                $sent_at->addSeconds(7);
            }
        }

        Session::flash('notifications', ['Le message a bien été envoyé aux professeurs enseignant dans l\'implantation ' . $email->examSession->location->name]);
        return redirect()->route('dashboard');
    }
}
