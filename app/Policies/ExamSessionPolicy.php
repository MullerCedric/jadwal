<?php

namespace App\Policies;

use App\ExamSession;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamSessionPolicy
{
    use HandlesAuthorization;

    public function update(User $user, ExamSession $examSession)
    {
        return $user->id === $examSession->user_id;
    }
}
