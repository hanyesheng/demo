<?php

namespace App\Http\Controllers\Api;

use App\AdminUser;
use App\Topic;
use App\AssumedName;
use App\Fan;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Transformers\TopicTransformer;
use App\Transformers\PostTransformer;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function store(UserRequest $request, ImageUploadHandler $uploader)
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
        $userInfo = AdminUser::withCount(['stars', 'fans', 'posts', 'mytopics'])->find($this->user()->id);
        return $this->response->item($userInfo, new UserTransformer());
    }
    //修改我的信息
    public function update(UserRequest $request)
    {
        $user = $this->user();
        $attributes = $request->only(['name', 'email', 'introduction']);
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }
    // 随机抽取花名
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
    //我的关注
    public function starUsers()
    {
        $user = $this->user();
        $stars = $user->stars;
        $userInfo = AdminUser::whereIn('id', $stars->pluck('star_id'))->withCount(['stars', 'fans', 'posts', 'mytopics'])->get();
        return $this->response->collection($userInfo, new UserTransformer());
    }
    //我的粉丝
    public function fanUsers()
    {
        $user = $this->user();
        $fans = $user->fans;
        $userInfo = AdminUser::whereIn('id', $fans->pluck('fan_id'))->withCount(['stars', 'fans', 'posts', 'mytopics'])->get();
        return $this->response->collection($userInfo, new UserTransformer());
    }

    // 个人页面
    // 某个用户的信息
    public function userIndex(AdminUser $user, Request $request)
    {
        $userInfo = AdminUser::withCount(['stars', 'fans', 'posts', 'mytopics'])->find($user->id);
        return $this->response->item($userInfo, new UserTransformer());
    }
    // 某个用户关注的话题
    public function userTopicsIndex(AdminUser $user, Request $request)
    {
        $topics = $user->mytopics();
        $sutopics = Topic::whereIn('id', $topics->pluck('topic_id'))->withCount(['posts', 'users','today_posts'])->orderBy('today_posts_count', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($sutopics, new TopicTransformer());
    }
    // 某个用户发布的post
    public function userPostsIndex(AdminUser $user, Request $request)
    {
        $posts = $user->posts()->with(['topics','user','images'])->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }
    // 关注某人
    public function fan(AdminUser $user)
    {
        $param = [
            'fan_id' => $this->user()->id,
            'star_id' => $user->id,
        ];

        Fan::firstOrCreate($param);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
    // 取消关注某人
    public function unfan(AdminUser $user)
    {
        $user->myfans($this->user()->id)->delete();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
    // 搜索结果页
    public function search()
    {
        // 验证
        $this->validate(request(),[
            'query' => 'required'
        ]);
        // 逻辑
        $query = request('query');
        $users = \App\AdminUser::search($query)->paginate(10);

        // 渲染
        return $this->response->paginator($users, new UserTransformer());
    }
}