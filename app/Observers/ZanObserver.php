<?php

namespace App\Observers;

use App\Notifications\PostZan;
use App\Zan;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ZanObserver
{
    public function created(Zan $zan)
    {
        $orPosts = $zan->orPosts;

        // 如果评论的作者不是话题的作者，才需要通知
        if (! $zan->user->isAuthorOf($orPosts)) {
            $orPosts->user->notify(new PostZan($zan));
        }
    }

}