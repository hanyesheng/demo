@extends("layout.main")
@section("content")
<div class="col-sm-8">
    <blockquote>
        <p>#{{$topic->name}}#</p>
        <small>
            内容：{{$topic->posts_count}} | 关注：<span class="users_count">{{$topic->users_count}}</span> |
        @if ($topic->users(\Auth::id())->exists())
            <a class="add-topic-button" add-value="1" add-topic="{{$topic->id}}" href="javascript:void(0);">√取消关注</a>
        @else
            <a class="add-topic-button" add-value="0" add-topic="{{$topic->id}}" href="javascript:void(0);">＋关注</a>
        @endif
            </small>
    </blockquote>
</div>
<div class="col-sm-8 blog-main">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            @foreach($posts as $post)
                @include('post.post')
            @endforeach
        </div>
    </div>
</div><!-- /.blog-main -->
@endsection


