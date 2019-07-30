<?php

namespace App\Http\Controllers\Api;

use App\Topic;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;

class TopicsController extends Controller
{
    //话题列表
    public function index(Topic $topic)
    {
        $query = $topic->query()->withCount(['posts','users','today_posts']);
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
//    话题日榜
    public function topByDay(Topic $topic)
    {
        $query = $topic->query()->withCount(['today_posts','users'])->orderBy('today_posts_count', 'desc')->offset(0)->limit(20)->get();
        return $this->response->collection($query, new TopicTransformer());
    }
}
