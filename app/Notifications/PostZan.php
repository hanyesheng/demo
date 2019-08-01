<?php

namespace App\Notifications;

use App\Zan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostZan extends Notification implements ShouldQueue
{
    use Queueable;

    public $zan;

    public function __construct(Zan $zan)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->zan = $zan;
    }

    public function via($notifiable)
    {
        // 开启通知的频道
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $orPosts = $this->zan->orPosts;

        // 存入数据库里的数据
        return [
            'zan_user_id' => $this->zan->user->id,
            'zan_user_name' => $this->zan->user->name,
            'zan_user_avatar' => $this->zan->user->image->path ?? NULL,
            'orPosts_id' => $orPosts->id,
            'orPosts_title' => $orPosts->title,
            'orPosts_assumed_name' => $orPosts->assumed_name,
        ];
    }
}