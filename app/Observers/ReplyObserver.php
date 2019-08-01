<?php

namespace App\Observers;

use App\Post;
use App\Notifications\PostReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Post $reply)
    {
        $orPosts = $reply->orPosts;

        // 如果评论的作者不是话题的作者，才需要通知
        if ($orPosts){
            if ( (! $reply->user->isAuthorOf($orPosts))&& (! $reply->forward_post_id = NULL)) {
                $orPosts->user->notify(new PostReplied($reply));
            }
        }

    }

}