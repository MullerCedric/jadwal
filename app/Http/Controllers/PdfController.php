<?php

namespace App\Http\Controllers;

use App\Preference;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function preferenceToPDF (Preference $preference) {
        $preference->load([
            'teacher',
            'examSession'
        ]);
        $examSession = $preference->examSession;
        $examSession->load('location');
        $teacher = $preference->teacher;
        $currDate = Carbon::now()->format('d/m/y');
        $data = compact('preference', 'examSession', 'teacher', 'currDate');
        return PDF::loadview('pdf.preferences', $data)->setPaper('a4', 'portrait');
    }
}
