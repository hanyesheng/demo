<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Auth;
class AdminUser extends Authenticatable implements JWTSubject
{
    protected $rememberTokenName = '';
    protected $fillable = [
        'name', 'email','phone', 'username', 'password','assumed_name','dice_id'
    ];
    protected $guarded = [];
    // 认证
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    // 搜索
    use Searchable;
    public function searchableAs()
    {
        return "admin_users";
    }
    // 定义有那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
        ];
    }

    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }
    // 清除未读消息
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    // 是否拥有某一模型
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 用户有哪一些角色
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    // 判断是否有某个角色，某些角色
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    // 给用户分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    // 取消用户分配的角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    // 用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

    // 用户的文章列表
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    // 用户的头像列表
    public function image()
    {
        return $this->hasOne(Image::class, 'user_id', 'id')->where(function($query) {
            $query->where('type', '=', 'avatar');
        })->orderBy('created_at', 'desc');
    }

    // 关注我的Fan模型
    public function fans()
    {
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }

    // 我关注的Fan模型
    public function stars()
    {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }

    // 我关注的话题模型
    public function mytopics()
    {
        return $this->hasMany(\App\UserTopic::class, 'user_id','id');
    }

    // 我关注的 和用户进行关联
    public function myfans($user_id)
    {
        return $this->hasOne(\App\Fan::class,'star_id', 'id')->where('fan_id', $user_id);
    }


    // 当前用户是否被uid关注了
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    // 当前用户是否关注了uid
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id', $uid)->count();
    }

    // 用户收到的通知
    public function notices()
    {
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }

    // 给用户增加通知
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);  // detach
    }

}
