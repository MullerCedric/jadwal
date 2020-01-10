<?php

namespace App\Http\Middleware;

use App\Preference;
use App\Teacher;
use Closure;

class EditIfExists
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
            case 'preferences':
                if ($token = $request->route()->parameter('token')) {
                    $examSession = $request->route()->parameter('exam_session');
                    $teacher = Teacher::where('token', $token)->firstOrFail();
                    $preference = Preference::where('teacher_id', $teacher->id)
                        ->where('exam_session_id', $examSession->id)
                        ->first();

                    if ($preference) {
                        return redirect()->route('preferences.edit', [
                            'preference' => $preference->id,
                            'token' => $token
                        ]);
                    }
                    break;
                }
            default:
                return $next($request);
        }
        return $next($request);
    }
}
