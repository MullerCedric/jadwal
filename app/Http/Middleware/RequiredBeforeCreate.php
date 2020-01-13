<?php

namespace App\Http\Middleware;

use App\Location;
use App\Teacher;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RequiredBeforeCreate
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
        $notifications = session('notifications') ?? [];
        $modelToCreate = false;

        switch ($model) {
            case 'exam_sessions':
                if (is_null(Teacher::first())) {
                    $modelToCreate = 'teachers';
                } else {
                    if (is_null(Location::first())) {
                        $modelToCreate = 'locations';
                    }
                }
                break;
            case 'messages':
                if (is_null(Auth::user()->examSessions()->first())) {
                    $modelToCreate = 'exam_sessions';
                    $notifications[] = 'Veuillez créer une session d\'examens avant d\'écrire un message';
                }
                break;
            case 'teachers':
                if (is_null(Location::first())) {
                    $modelToCreate = 'locations';
                    $notifications[] = 'Veuillez créer une implantation avant d\'ajouter un professeur';
                }
                break;
            default:
                return $next($request);
        }

        if ($modelToCreate) {
            Session::flash('notifications', $notifications);
            return redirect()->route($modelToCreate . '.create');
        }

        return $next($request);
    }
}
