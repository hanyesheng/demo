@extends("layout.main")
@section("content")
@foreach($topics as $topic)
    <div class="col-md-3 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="/topic/{{$topic->id}}">#{{$topic->name}}#</a><br>
                <span>
                    内容：{{$topic->posts_count}} | 关注：<span class="users_count">{{$topic->users_count}}</span> |
                    @if ($topic->users(\Auth::id())->exists())
                        <a class="add-topic-button" add-value="1" add-topic="{{$topic->id}}" href="javascript:void(0);">√取消关注</a>
                    @else
                        <a class="add-topic-button" add-value="0" add-topic="{{$topic->id}}" href="javascript:void(0);">＋关注</a>
                    @endif
                </span>
            </div>
        </div>
    </div>
@endforeach
<div class="col-md-12">{{$topics->links()}}</div>
@endsection


