<?php

namespace App\Http\Middleware;

use App\ExamSession;
use Closure;
use Illuminate\Support\Facades\Session;

class ShowIfSent
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
        switch ($model) {
            case 'exam_sessions':
                $resource = $request->route()->parameter('exam_session');
                $notifications[] = 'Vous ne pouvez plus modifier une session qui a déjà été envoyée';
                break;
            case 'messages':
                $resource = $request->route()->parameter('message');
                $notifications[] = 'Vous ne pouvez plus modifier un message qui a déjà été envoyé';
                break;
            case 'preferences':
                $resource = $request->route()->parameter('preference');
                if ($token = $request->route()->parameter('token')) {
                    if ($resource->isSent()) {
                        Session::flash('notifications', $notifications);
                        return redirect()->route('preferences.show', [
                            'preference' => $resource->id,
                            'token' => $token
                        ]);
                    }
                    break;
                }
            default:
                return $next($request);
        }

        if ($resource->isSent()) {
            Session::flash('notifications', $notifications);
            return redirect()->route($model . '.show', [rtrim($model, "s") => $resource->id]);
        }

        return $next($request);
    }
}
