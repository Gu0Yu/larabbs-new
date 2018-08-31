<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        // 当前登录用户的回复可以删除或当前登录用户的话题下回复亦可
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
