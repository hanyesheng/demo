<div class="panel panel-default">
    <div class="panel-heading">
        @if ($post->user->avatar)
            <img class="user-avatar" src="{{$post->user->avatar}}">
        @else
            <img class="user-avatar" src="/defaultAvatar.jpg">
        @endif
        <a href="/user/{{$post->user->id}}">{{$post->user->assumed_name}}</a><small class="text-muted">{{$post->created_at->diffForHumans()}}</small>
    </div>
    <div class="panel-body">
        <div class="media">
            <div class="media-body">
                <div class="col-md-12">
                    <div class="post-content"><p class="lead">{{$post->id}}.{{$post->title}}</p></div>
                </div>
                @if($post->avatar)
                    <div class="col-md-12"><img src="{{$post->avatar}}" alt="..." class="img-rounded post-img"></div>
                @endif
            </div>
        </div>
    </div>
    <hr class="panel-body-hr">
    <div class="panel-body-action">
        <div class="row">
            <div class="col-md-12">
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
                        @foreach($post->topics as $topic)
                            <a class="topic-font" href="/topic/{{$topic->id}}">#{{$topic->name}}#</a>
                        @endforeach
                    @else
                        <a href="/login">登录后完成更多操作</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <hr class="panel-body-hr-bottom">
    <div class="panel-body-action">
        <div class="row">
            <div class="col-md-12">
                <p class="blog-post-meta post-action">
                    @include('post.postlist')
                </p>
            </div>
        </div>
    </div>
</div>
{{--转发弹窗--}}
<div class="modal fade" id="reposts_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        @include('post.repost')
    </div>
</div>