<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\UserTopic;

class TopicController extends Controller
{

    // 列表
    public function index()
    {
        $topics = Topic::withCount(['posts','users'])->orderBy('posts_count', 'desc')->paginate(16);
        return view("topic/index", compact('topics'));
    }
    // 专题详情页
    public function show(Topic $topic)
    {
        // 带文章数的专题
        $topic = Topic::withCount(['posts','users'])->find($topic->id);

        // 专题的文章列表，按照创建时间倒叙排列，前10个
        $posts = $topic->posts()->orderBy('created_at', 'desc')->withCount(['comments', 'zans','reposts'])->get();

        // 属于我的post，但是未投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }
    // 关注话题
    public function addtopic(Topic $topic)
    {
        $param = [
            'user_id' => \Auth::id(),
            'topic_id' => $topic->id,
        ];

        UserTopic::firstOrCreate($param);
        $topicusers = Topic::withCount(['users'])->find($topic->id);
        return [
            'error' => 0,
            'users' => $topicusers->users_count,
            'msg' => ''
        ];
    }
    // 取消关注话题
    public function removetopic(Topic $topic)
    {
        $topic->usertopic(\Auth::id())->delete();
        $topicusers = Topic::withCount(['users'])->find($topic->id);
        return [
            'error' => 0,
            'users' => $topicusers->users_count,
            'msg' => ''
        ];
    }

}
