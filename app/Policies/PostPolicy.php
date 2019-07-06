<?php

namespace App\Policies;

use App\Post;
use App\AdminUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // 修改权限
    public function update(AdminUser $user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    // 删除权限
    public function delete(AdminUser $user, Post $post)
    {
        return $user->id == $post->user_id;
    }
}
