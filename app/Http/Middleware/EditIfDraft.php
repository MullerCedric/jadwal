<?php

namespace App\Http\Middleware;

use App\ExamSession;
use Closure;

class EditIfDraft
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
                $resource = ExamSession::withTrashed()->findOrFail($request->route()->parameter('id'));
                break;
            case 'messages':
                $resource = $request->route()->parameter('message');
                break;
            case 'preferences':
                $resource = $request->route()->parameter('preference');
                if ($token = $request->route()->parameter('token')) {
                    if (!$resource->isSent() && !$resource->isValidated()) {
                        return redirect()->route('preferences.edit', [
                            'preference' => $resource->id,
                            'token' => $token
                        ]);
                    }
                    break;
                } else {
                    if ($resource->isSent() && !$resource->isValidated()) {
                        return redirect()->route('preferences.edit', [
                            'preference' => $resource->id
                        ]);
                    }
                    return $next($request);
                }
            default:
                return $next($request);
        }

        if (!$resource->isValidated()) {
            return redirect()->route($model . '.edit', [rtrim($model, "s") => $resource->id]);
        }
        return $next($request);
    }
}
