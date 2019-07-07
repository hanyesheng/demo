@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <div style="height: 20px;">
    </div>
    <div>
        @foreach($posts as $post)
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div class="media-body">
                        {{$post->title}}
                        <a href="/posts/{{$post->id}}" >#{{$post->title}}#</a>
                        <p class="blog-post-meta">赞 {{$post->zans_count}}  | 评论 {{$post->comments_count}}</p>
                    </div>
                    <div class="media-right">
                        <button type="button" class="close" aria-label="Close"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                        <button type="button" class="close" aria-label="Close"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @if ($post->user->avatar)
                <img class="user-avatar" src="{{$post->user->avatar}}">
                @else
                <img class="user-avatar" src="/defaultAvatar.jpg">
                @endif
                <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a><small>{{$post->created_at->diffForHumans()}}</small>
            </div>
        </div>
        @endforeach

        {{$posts->links()}}

    </div><!-- /.blog-main -->
</div>
@endsection