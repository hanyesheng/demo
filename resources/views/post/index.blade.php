@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <div style="height: 20px;">
    </div>
    <div>
        @foreach($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></p>

            <p>{{ str_limit($post->content, 100, '...')}}</p>
            <p class="blog-post-meta">赞 {{$post->zans_count}}  | 评论 {{$post->comments_count}}</p>
        </div>
        @endforeach

        {{$posts->links()}}

    </div><!-- /.blog-main -->
</div>
@endsection