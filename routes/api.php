<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
],function($api) {

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function($api) {
//            登陆注册
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
    });
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function($api) {
        // 游客可以访问的接口
        // post列表
        $api->get('posts', 'PostController@index')
            ->name('api.posts.index');

        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 我的信息
            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // 编辑登录用户信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            // 图片资源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            // 获取花名
            $api->patch('assumed_name', 'UsersController@assumedname')
                ->name('api.user.update');
            // 我关注的
            $api->get('starUsers', 'UsersController@starUsers')
                ->name('api.user.starUsers');
            // 关注我的
            $api->get('fanUsers', 'UsersController@fanUsers')
                ->name('api.user.fanUsers');
            // 搜索
            $api->get('users/search', 'UsersController@search')
                ->name('api.user.search');


            // 话题相关
            // 所有话题
            $api->get('topics', 'TopicsController@index')
                ->name('api.topics.index');
            // 话题日榜
            $api->get('topByDay', 'TopicsController@topByDay')
                ->name('api.topics.topByDay');
            // 我的话题
            $api->get('my_topics', 'TopicsController@my')
                ->name('api.topics.my');
            // 关注话题
            $api->get('topics/{topic}/add', 'TopicsController@addTopic')
                ->name('api.topics.add');
            // 取消关注话题
            $api->get('topics/{topic}/remove', 'TopicsController@removeTopic')
                ->name('api.topics.remove');
            // 搜索
            $api->get('topics/search', 'TopicsController@search')
                ->name('api.topics.search');

            // 话题页面
            // 某个话题的信息
            $api->get('topics/{topic}/show', 'TopicsController@topicIndex')
                ->name('api.topics.show');
            // 某个话题的post
            $api->get('topics/{topic}/posts', 'TopicsController@topicPosts')
                ->name('api.topics.posts');

            // post相关
            // 发布post
            $api->post('posts', 'PostController@store')
                ->name('api.posts.store');
            // 关注人post列表
            $api->get('starPosts', 'PostController@starPosts')
                ->name('api.posts.starPosts');
            // 关注话题post列表
            $api->get('userTopicPosts', 'PostController@userTopicPosts')
                ->name('api.posts.userTopicPosts');
            // 点赞
            $api->get('posts/{post}/zan', 'PostController@zan')
                ->name('api.posts.zan');
            // 取消赞
            $api->get('posts/{post}/unzan', 'PostController@unzan')
                ->name('api.posts.unzan');
            // 搜索
            $api->get('posts/search', 'PostController@search')
                ->name('api.posts.search');
            // 删除
            $api->get('posts/{post}/delete', 'PostController@delete')
                ->name('api.posts.delete');

            // post页面
            // 某个post信息
            $api->get('posts/{post}/show', 'PostController@show')
                ->name('api.posts.show');
            // 某个post的转发
            $api->get('posts/{post}/reposts', 'PostController@reposts')
                ->name('api.posts.reposts');
            // 某个post的链条
            $api->get('posts/{post}/orPosts', 'PostController@orPosts')
                ->name('api.posts.orPosts');

            // 个人页面
            // 某个用户的信息
            $api->get('users/{user}/index', 'UsersController@userIndex')
                ->name('api.users.index');
            // 某个用户发布的post
            $api->get('users/{user}/posts', 'UsersController@userPostsIndex')
                ->name('api.users.posts.index');
            // 某个用户关注的话题
            $api->get('users/{user}/topics', 'UsersController@userTopicsIndex')
                ->name('api.users.topics.index');
            // 关注某人
            $api->post('users/{user}/fan', 'UsersController@fan')
                ->name('api.users.fan');
            // 取消关注某人
            $api->post('users/{user}/unfan', 'UsersController@unfan')
                ->name('api.users.unfan');

            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            // 通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            // 标记消息通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');

        });
    });


});

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});