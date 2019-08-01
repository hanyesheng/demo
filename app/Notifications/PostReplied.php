<?php

namespace App\Notifications;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    public function __construct(Post $reply)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        // 开启通知的频道
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $orPosts = $this->reply->orPosts;

        // 存入数据库里的数据
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->title,
            'reply_assumed_name' => $this->reply->assumed_name,
            'reply_user_id' => $this->reply->user->id,
            'reply_user_name' => $this->reply->user->name,
            'reply_user_avatar' => $this->reply->user->image->path ?? NULL,
            'orPosts_id' => $orPosts->id,
            'orPosts_title' => $orPosts->title,
            'orPosts_assumed_name' => $orPosts->assumed_name,
        ];
    }
}