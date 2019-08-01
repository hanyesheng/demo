<?php

namespace App;


class Zan extends Model
{
    // 关联用户
    public function user()
    {
        return $this->belongsTo('App\AdminUser');
    }
    //
    public function orPosts()
    {
        return $this->belongsTo(\App\Post::class, 'post_id','id');
    }
}
