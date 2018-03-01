<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyPolicy extends Policy implements ShouldQueue
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply);
    }
}
