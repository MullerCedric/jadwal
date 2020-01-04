<?php

namespace App\Http\Controllers;

use App\ExamSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClosedExamSessionController extends Controller
{
    public function index()
    {
        $examSessions = Auth::user()->examSessions()->onlyTrashed()->with([
            'location',
            'location.teachers'
        ])->get();
        $today = \Carbon\Carbon::now()->startOfDay();
        $currentTab = 'closed';
        return view('exam_sessions.index', compact('examSessions', 'today', 'currentTab'));
    }

    public function store(ExamSession $examSession)
    {
        $examSession->delete();
        Session::flash('notifications', ['La session "' . $examSession->title . '" a été clôturée']);
        return redirect()->route('closed_exam_sessions.index');
    }

    public function destroy(ExamSession $examSession)
    {
        $title = $examSession->title;
        $examSession->forceDelete();
        Session::flash('notifications', ['La session "' . $title . '" a été définitivement supprimée']);
        return redirect()->route('closed_exam_sessions.index');
    }
}
