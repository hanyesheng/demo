<div class="media">
    <div class="media-body">
    {{$post->level_id}}.
    <a href="/user/{{$post->user->id}}">{{$post->user->assumed_name}} </a><small class="text-muted">{{$post->created_at->diffForHumans()}} </small>:
    {{$post->title}}
    @if($post->avatar)<a href="{{$post->avatar}}" >查看图片</a>@endif
    </div>
    <div class="media-left">
        <p class="blog-post-meta post-action">
            <small class="text-muted">
            @if (\Auth::check())
                <a type="button" data-toggle="modal" href="#" data-target="#reposts_count_{{$post->id}}">
                    <span class="glyphicon glyphicon-share" aria-hidden="true">{{$post->reposts_count}}</span>
                </a>
                |
                @if ($post->zan(\Auth::id())->exists())
                    <a type="button" class="like-post-button" like-zans="{{$post->zans_count}}" like-value="1" like-post="{{$post->id}}" href="javascript:void(0);">👍🏼</a>
                    <a class="zans_count">{{$post->zans_count}}</a>
                @else
                    <a type="button" class="like-post-button" like-zans="{{$post->zans_count}}" like-value="0" like-post="{{$post->id}}" href="javascript:void(0);">👍🏼</a>
                    <a class="zans_count">{{$post->zans_count}}</a>
                @endif
            @else
                <a href="/login">登录</a>
            @endif
            </small>
        </p>
    </div>
</div>
{{--转发弹窗--}}
<div class="modal fade" id="reposts_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        @include('post.repost')
    </div>
</div>

@include('post.postlist')