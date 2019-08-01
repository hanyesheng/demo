<?php

namespace App\Transformers;

use App\AdminUser;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles'];

    public function transform(AdminUser $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'assumed_name' => $user->assumed_name,
            'dice_id' => $user->dice_id,
            'email' => $user->email,
            'gender' => $user->gender,
            'phone' => $user->phone,
            'introduction' => $user->introduction,
            'fans_count' => (int)$user->fans_count,
            'stars_count' => (int)$user->stars_count,
            'posts_count' => (int)$user->posts_count,
            'mytopics_count' => (int)$user->mytopics_count,
            'hasFan' => $user->hasFan(\Auth::guard('api')->user()->id) ? true : false,
            'avatar' => $user->image->path ?? NULL,
            'bound_phone' => $user->phone ? true : false,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

    public function includeRoles(AdminUser $user)
    {
        return $this->collection($user->roles, new RoleTransformer());
    }
}
