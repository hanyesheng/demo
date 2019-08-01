<?php

namespace App;

use App\Model;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

// 表 => posts

class Post extends Model
{
    use Searchable;
    use SoftDeletes;
    protected $table = 'posts'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
//    protected $table = "...";(按照规则自动对应posts  否则手动对应)
    // 定义索引里面的type
    public function searchableAs()
    {
        return "post";
    }

    // 定义有那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    // 关联用户
    public function user()
    {
        return $this->belongsTo('App\AdminUser');
    }

    // 评论模型
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    // 和用户进行关联
    public function zan($user_id)
    {
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }
    // 文章的所有赞
    public function zans()
    {
        return $this->hasMany(\App\Zan::class);
    }
    // 是否点赞此post
    public function haszan($user_id)
    {
        return $this->zans()->where('user_id', $user_id)->count();
    }
    //文章所有转发（转发此post的数量）
    public function reposts()
    {
        return $this->hasMany(\App\Post::class,'forward_post_id','id');
    }
    //文章的所有图片
    public function images()
    {
        return $this->hasMany(Image::class, 'post_id', 'id')->where(function($query) {
            $query->where('type', '=', 'post');
        })->orderBy('created_at', 'desc');
    }
    //文章的所有话题
    public function topics()
    {
        return $this->belongsToMany(\App\Topic::class, 'post_topics', 'post_id','topic_id');
    }

    public function lastposts()
    {
        return $this->hasMany(\App\Post::class, 'id','forward_post_id')->withCount(['zans','reposts']);
    }
    public function orPosts()
    {
        return $this->belongsTo(\App\Post::class, 'forward_post_id','id');
    }



    // 属于某个作者的文章
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }

    // 不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function($q) use($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }

    // 全局scope的方式
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope("avaiable", function(Builder $builder){
            $builder->whereIn('status', [0, 1]);
        });
    }
}
