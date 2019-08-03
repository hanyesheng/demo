<?php

namespace App\Http\Controllers\Api;

use App\AdminUser;
use App\Post;
use App\Zan;
use App\Topic;
use App\PostTopic;
use App\Image;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\PostRequest;
use App\Transformers\PostTransformer;

class PostController extends Controller
{
    //
    public function store(PostRequest $request ,ImageUploadHandler $uploader,Image $image)
    {
        $post = new Post;
        $post->user_id = $this->user()->id;
        $post->title = $request->title;
        $post->topics()->name = $request->topic_name;
        $post->assumed_name = $this->user()->assumed_name;
        if ($request->post_id){
            $lastpost = Post::where('id', $request->post_id)->first();
            $post->level_id = $lastpost->level_id + 1;
            $post->original_post_id = $lastpost->original_post_id;
            $post->forward_post_id = $lastpost->id;
        }else{
            $post->level_id = 1;
        }
        $post->save();
//        生成图片
        if ($request->file('avatar')) {
            $image = new Image;
            $image->type = 'post';
            $size = 1024;
            $result = $uploader->save($request->avatar, str_plural($image->type), $user->id, $size);
            $image->path = $result['path'];
            $image->type = 'post';
            $image->user_id = $user->id;
            $image->post_id = $post->id;
            $image->save();
        }
        //        生成话题
        if(request('topic_name')){
            if (Topic::where('name', request('topic_name'))->count() > 0) {
                $topic = Topic::where('name', request('topic_name'))->first();
                $posttopic = new PostTopic;
                $posttopic->post_id = $post->id;
                $posttopic->topic_id = $topic->id;
                $posttopic->save();
            }else{
                $topic = new Topic;
                $topic->name = request('topic_name');
                $topic->save();
                $posttopic = new PostTopic;
                $posttopic->post_id = $post->id;
                $posttopic->topic_id = $topic->id;
                $posttopic->save();
            }
        }
        //        对新建的推送写入原始postid(id)
        if ($request->post_id){
            return $this->response->item($post, new PostTransformer())
                ->setStatusCode(201);
        }else{
            $newpost = Post::where('id', $post->id)->first();
            $newpost->original_post_id = $newpost->id;
            $newpost->save();
            return $this->response->item($newpost, new PostTransformer())
                ->setStatusCode(201);
        }
    }

    // 删除逻辑
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function index(Post $post)
    {
        $query = $post->query()->withCount(['reposts','zans'])->orderBy('created_at', 'desc')->orderBy('zans_count', 'desc');
        $post->load('user');
        $posts = $query->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }
    // 关注人post列表
    public function starPosts()
    {
        $user = $this->user();
        $user_ids = $user->stars->pluck('star_id')->toArray();
        array_push($user_ids, $user->id);
        $posts =  Post::whereIn('user_id', $user_ids)
            ->with('user','topics','images')
            ->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }
    // 关注话题post列表
    public function userTopicPosts()
    {
        $user = $this->user();
        $topic_ids = $user->mytopics->pluck('topic_id')->toArray();
        $post_ids = PostTopic::whereIn('topic_id', $topic_ids)->pluck('post_id')->toArray();
        $posts =  Post::whereIn('id', $post_ids)
            ->with(['topics','user','images'])
            ->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }

    // 获取某个post的信息
    public function show(Post $post)
    {
        $postInfo = Post::with('user','topics','images')->withCount(['reposts','zans'])->find($post->id);
        return $this->response->item($postInfo, new PostTransformer());
    }
    // 获取某个post的转发
    public function reposts(Post $post)
    {
        $posts = $post->reposts()->with('user','topics','images')->withCount(['reposts','zans'])->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }
    // 获取某个post的链条
    public function orPosts(Post $post)
    {
        $post_id = $post->orPosts()->pluck('id')->toArray();
        $posts =  Post::whereIn('id', $post_id)
            ->with(['topics','user','images'])
            ->orderBy('created_at', 'desc')->paginate(10);
        return $this->response->paginator($posts, new PostTransformer());
    }

    // 赞
    public function zan(Post $post)
    {
        $param = [
            'user_id' => $this->user()->id,
            'post_id' => $post->id,
        ];

        Zan::firstOrCreate($param);
        $post = Post::withCount(['reposts','zans'])->find($post->id);
        return $this->response->item($post, new PostTransformer());
    }

    // 取消赞
    public function unzan(Post $post)
    {
        $post->zan($this->user()->id)->delete();
        $post = Post::withCount(['reposts','zans'])->find($post->id);
        return $this->response->item($post, new PostTransformer());
    }
    //搜索
    // 搜索结果页
    public function search()
    {
        // 验证
        $this->validate(request(),[
            'query' => 'required'
        ]);
        // 逻辑
        $query = request('query');
        $posts = \App\Post::with(['topics','user','images'])->search($query)->paginate(10);

        // 渲染
        return $this->response->paginator($posts, new PostTransformer());
    }
}
