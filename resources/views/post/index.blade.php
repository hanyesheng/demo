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
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td>
                                    <button type="button" class="post-control" aria-label="Close"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            </td></tr>
                            <tr><td align="center">
                                    <button type="button" class="post-control" ria-label="Close"><span class="zans_count" aria-hidden="true">{{$post->zans_count}}</span></button>
                            </td></tr>
                            <tr><td>
                                    <button type="button" class="post-control" aria-label="Close"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                            </td></tr>
                        </table>
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