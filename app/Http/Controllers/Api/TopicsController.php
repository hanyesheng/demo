<?php

namespace App\Http\Controllers\Api;

use App\Topic;
use App\UserTopic;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;
use App\Transformers\PostTransformer;

class TopicsController extends Controller
{
    //话题列表
    public function index(Topic $topic)
    {
        $query = $topic->query()->withCount(['posts','users','today_posts'])->inRandomOrder();
        $topics = $query->paginate(20);
        return $this->response->paginator($topics, new TopicTransformer());
    }
    //我的话题
    public function my()
    {
        $user = $this->user();
        $topicId = $user->mytopics();
        $topics = Topic::whereIn('id', $topicId->pluck('topic_id'))->withCount(['posts', 'users','today_posts'])->orderBy('today_posts_count', 'desc')->paginate(10);
        return $this->response->paginator($topics, new TopicTransformer());
    }
    // 话题日榜
    public function topByDay(Topic $topic)
    {
        $query = $topic->query()->withCount(['today_posts','users'])->orderBy('today_posts_count', 'desc')->offset(0)->limit(20)->get();
        return $this->response->collection($query, new TopicTransformer());
    }

    // 获取某个话题的信息
    public function topicIndex(Topic $topic, Request $request)
    {
        $topicInfo = Topic::withCount(['posts','users','today_posts'])->find($topic->id);
        return $this->response->item($topicInfo, new TopicTransformer());
    }
    // 获取某个话题的post
    public function topicPosts(Topic $topic, Request $request)
    {
        $posts = $topic->posts()->with(['topics','user','images'])->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }

    // 关注话题
    public function addtopic(Topic $topic)
    {
        $param = [
            'user_id' => $this->user()->id,
            'topic_id' => $topic->id,
        ];

        UserTopic::firstOrCreate($param);
        $topicInfo = Topic::withCount(['posts','users','today_posts'])->find($topic->id);
        return $this->response->item($topicInfo, new TopicTransformer());
    }
    // 取消关注话题
    public function removetopic(Topic $topic)
    {
        $topic->usertopic($this->user()->id)->delete();
        $topicInfo = Topic::withCount(['posts','users','today_posts'])->find($topic->id);
        return $this->response->item($topicInfo, new TopicTransformer());
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
        $topics = \App\Topic::search($query)->paginate(10);

        // 渲染
        return $this->response->paginator($topics, new TopicTransformer());
    }
}
