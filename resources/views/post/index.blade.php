@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <div style="height: 20px;">
    </div>
    <div>
        @foreach($posts as $post)
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
                            {{$post->title}}
                            @foreach($post->topics as $topic)
                                <a class="topic-font" href="/topic/{{$topic->id}}">#{{$topic->name}}#</a>
                            @endforeach
                        </div>
                        @if($post->avatar)
                            <div class="col-md-12"><img src="{{$post->avatar}}" alt="..." class="img-rounded post-img"></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-12">
                        <p class="blog-post-meta post-action">
                            @if (\Auth::check())
                                <a type="button" data-toggle="modal" href="#" data-target="#reposts_count_{{$post->id}}">
                                    💞 {{$post->reposts_count}}
                                </a>
                                |
                                <a type="button" data-toggle="modal" href="#" data-target="#comments_count_{{$post->id}}">
                                    💬 {{$post->comments_count}}
                                </a>|
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
        </div>

        <div class="modal fade" id="reposts_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form action="/repost" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-body">
                                {{csrf_field()}}
                                <input class="file-loading preview_input" type="hidden" value="{{$post->id}}"  style="width:72px" name="forward_post_id">
                                <input class="file-loading preview_input" type="hidden" value="{{$post->original_post_id}}" style="width:72px" name="original_post_id">
                                <div class="input-group repost">
                                    <input type="text" class="form-control" value="@foreach($post->topics as $topic)#{{$topic->name}}#@endforeach" name="title" placeholder="..." aria-describedby="basic-addon2">

                                    <span class="input-group-addon" id="basic-addon2">转发@ {{$post->user->assumed_name}}</span>
                                </div>
                                <div class="jumbotron">
                                    <div class="row">
                                        <div class="form-group add-img">
                                            <input class="file-loading preview_input" id="exampleInputFile" type="file" name="avatar">
                                            <img  class="preview_img img-rounded" src="" alt="" class="img-rounded">
                                        </div>
                                        <div class="col-md-12">
                                            //:{{$post->title}}
                                            @foreach($post->topics as $topic)
                                                <a class="topic-font" href="/topic/{{$topic->id}}">#{{$topic->name}}#</a>
                                            @endforeach
                                        </div>
                                        @if($post->avatar)
                                            <div class="col-md-12"><img src="{{$post->avatar}}" alt="..." class="img-rounded post-img"></div>
                                        @endif
                                    </div>
                                </div>
                                @include('layout.error')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="comments_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        comments_count
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{$posts->links()}}

    </div><!-- /.blog-main -->
</div>
@endsection