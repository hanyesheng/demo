<?php

namespace App;
use Laravel\Scout\Searchable;

class Topic extends Model
{
    use Searchable;
    public function searchableAs()
    {
        return "topics";
    }

    // 定义有那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
    // 属于这个专题的所有文章
    public function posts()
    {
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
    // 今日贴
    public function today_posts()
    {
        $today = today()->toDateString();
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id')->whereDate('posts.created_at','=', $today);
    }
    // 和用户进行关联
    public function usertopic($user_id)
    {
        return $this->hasOne(\App\UserTopic::class)->where('user_id', $user_id);
    }
//    专题的关注人数
    public function users()
    {
        return $this->hasMany(\App\UserTopic::class, 'topic_id');
    }
    // 是否关注此话题
    public function hastopic($user_id)
    {
        return $this->users()->where('user_id', $user_id)->count();
    }
}
