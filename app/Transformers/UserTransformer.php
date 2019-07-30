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
            'introduction' => $user->introduction,
            'avatar' => $user->image->path,
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
