<?php

namespace App\Http\Controllers\Api;

use App\AdminUser;
use App\AssumedName;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $names = AssumedName::inRandomOrder()->first();
//        逻辑
        $assumedName = $names->name;
        $assumed_name = $assumedName;
        $dice_id = 2;
        $username = $verifyData['phone'];
        $name = $request->name;
        $phone = $verifyData['phone'];
        $password = bcrypt($request->password);

        $user = AdminUser::create(compact('username','name','phone', 'password','assumed_name','dice_id'));

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }
//获取我的信息
    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
//修改我的信息
    public function update(UserRequest $request)
    {
        $user = $this->user();
        $attributes = $request->only(['name', 'email', 'introduction']);
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }
//    随机抽取花名
    public function assumedname(UserRequest $request)
    {
        $user = $this->user();
        $attributes = $request->only(['dice_id','assumed_name']);
        if ($user->dice_id>0) {
            $names = AssumedName::inRandomOrder()->first();
//        逻辑
            $assumedname = $names->name;
            $user->dice_id = $user->dice_id - 1;
        }else{
            $assumedname = $user->assumed_name;
            $user->dice_id = 0;
        }
        $user->assumed_name = $assumedname;
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }
}