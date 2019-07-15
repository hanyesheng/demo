@extends("layout.main")
@section("content")

<div class="col-sm-8 blog-main">
    @if (\Auth::check())
    <div style="display: flex;overflow-x: scroll;margin-bottom: 20px">
        @foreach($sutopics as $topic)
            <div class="pull-left" style="margin-right: 10px;">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/topic/{{$topic->id}}" style="white-space: nowrap">#{{$topic->name}}#</a><br>
                        <span style="white-space: nowrap">
                        内容：{{$topic->posts_count}} | 关注：<span class="users_count">{{$topic->users_count}}</span>
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="pull-left">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/alltopics" style="white-space: nowrap">所有话题>></a>
                    </div>
                </div>
            </div>
    </div>
    @endif
    @foreach($posts as $post)
        @include('post.post')
    @endforeach
    {{$posts->links()}}
</div>
@endsection