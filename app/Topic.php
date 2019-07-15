<?php

namespace App;

class Topic extends Model
{

    // 属于这个专题的所有文章
    public function posts()
    {
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
//    专题的关注人数
    public function users()
    {
        return $this->hasMany(\App\UserTopic::class, 'topic_id');
    }

}
