<?php

namespace App\Http\Middleware;

use App\ExamSession;
use App\Location;
use App\Message;
use App\Teacher;
use Closure;

class CreateIfEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $model
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {
        switch ($model) {
            case 'exam_sessions':
                if (is_null(ExamSession::withTrashed()->first())) {
                    return redirect()->route('exam_sessions.create');
                }
                break;
            case 'locations':
                if (is_null(Location::first())) {
                    return redirect()->route('locations.create');
                }
                break;
            case 'messages':
                if (is_null(Message::first())) {
                    return redirect()->route('messages.create');
                }
                break;
            case 'teachers':
                if (is_null(Teacher::first())) {
                    return redirect()->route('teachers.create');
                }
                break;
        }

        return $next($request);
    }
}
