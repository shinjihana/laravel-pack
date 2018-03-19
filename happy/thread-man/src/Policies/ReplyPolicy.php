<?php

namespace Happy\ThreadMan\Policies;

use App\User;
use Happy\ThreadMan\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reply $reply)
    {
        return $user->id == $reply->user_id;
    }
}
