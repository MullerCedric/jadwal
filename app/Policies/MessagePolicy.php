<?php

namespace App\Policies;

use App\Message;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function crudExisting(User $user, Message $message)
    {
        return $user->id === $message->user_id;
    }
}
