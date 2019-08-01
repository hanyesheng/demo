<div class="panel panel-default">
    <div class="panel-heading">
        @if ($post->user->image->path ?? NULL)
            <img class="user-avatar" src="{{$post->user->image->path}}">
        @else
            <img class="user-avatar" src="/defaultAvatar.jpg">
        @endif
        <a href="/user/{{$post->user->id}}">{{$post->user->assumed_name}}</a><small class="text-muted">{{$post->created_at->diffForHumans()}}</small>
        <div class="topic-left media-left">
            @foreach($post->topics as $topic)
                <a class="topic-font" href="/topic/{{$topic->id}}">#{{$topic->name}}#</a>
            @endforeach
        </div>
    </div>
    <div class="panel-body">
        <div class="media">
            <div class="media-body">
                <div class="post-content"><p class="lead">{{$post->level_id}}.{{$post->title}}</p></div>
                @if($post->images)
                    @foreach($post->images as $images)
                    <img src="{{$images->path}}" alt="..." class="img-rounded post-img">
                    @endforeach
                @endif
            </div>
            <div class="media-left">
                <p class="blog-post-meta post-action">
                    @if (\Auth::check())
                        <a type="button" data-toggle="modal" href="#" data-target="#reposts_count_{{$post->id}}">
                            💞 {{$post->reposts_count}}
                        </a>
                        |
                        @if ($post->zan(\Auth::id())->exists())
                            <a type="button" class="like-post-button" like-zans="{{$post->zans_count}}" like-value="1" like-post="{{$post->id}}" href="javascript:void(0);">👍🏼</a><a class="zans_count">{{$post->zans_count}}</a>
                        @else
                            <a type="button" class="like-post-button" like-zans="{{$post->zans_count}}" like-value="0" like-post="{{$post->id}}" href="javascript:void(0);">👍🏼</a><a class="zans_count">{{$post->zans_count}}</a>
                        @endif
                    @else
                        <a href="/login">登录后完成更多操作</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <hr class="panel-body-hr">
    <div class="panel-body-action">
        @include('post.postlist')
    </div>
</div>
{{--转发弹窗--}}
<div class="modal fade" id="reposts_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        @include('post.repost')
    </div>
</div>