<?php

namespace App\Policies;

use App\Message;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Message $message)
    {
        return $user->id === $message->user_id;
    }

    public function update(User $user, Message $message)
    {
        return $user->id === $message->user_id;
    }
}
