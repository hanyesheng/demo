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
                    <div class="media-right">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td>
                                    <button type="button" class="post-control" ><span class="glyphicon glyphicon-chevron-up"></span></button>
                            </td></tr>
                            <tr><td align="center">
                                    <span class="zans_count">{{$post->zans_count}}</span>
                            </td></tr>
                            <tr><td>
                                    <button type="button" class="post-control" ><span class="glyphicon glyphicon-chevron-down"></span></button>
                            </td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-12">
                        <p class="blog-post-meta">
                            <a role="button" data-toggle="collapse" href="#reposts_count_{{$post->id}}" aria-expanded="false" aria-controls="reposts_count_{{$post->id}}">
                                转发 {{$post->reposts_count}}
                            </a>
                            |
                            <a role="button" data-toggle="collapse" href="#comments_count_{{$post->id}}" aria-expanded="false" aria-controls="comments_count_{{$post->id}}">
                                评论 {{$post->comments_count}}
                            </a>
                        </p>
                        <div class="collapse" id="reposts_count_{{$post->id}}">
                            <div class="well">
                                <form action="/repost" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input class="file-loading preview_input" type="hidden" value="{{$post->id}}"  style="width:72px" name="forward_post_id">
                                    <input class="file-loading preview_input" type="hidden" value="{{$post->original_post_id}}" style="width:72px" name="original_post_id">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">转发//</label>
                                        <div class="col-sm-10 input-group"><textarea id="title" name="title" class="col-sm-10 form-control"></textarea></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">话题</label>
                                        <div class="col-sm-10 input-group">
                                            <span class="input-group-addon">#</span>
                                            <input type="text" class="form-control" value="@foreach($post->topics as $topic){{$topic->name}}@endforeach" name="topic_name">
                                            <span class="input-group-addon">#</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">添加图片</label>
                                        <div class="col-sm-10">
                                            <input class="file-loading preview_input" type="file"  style="width:72px" name="avatar">
                                            <img  class="preview_img" src="" alt="" class="img-rounded">
                                        </div>
                                    </div>
                                    @include('layout.error')
                                    <button type="submit" class="btn btn-default">提交</button>
                                </form>
                            </div>
                        </div>
                        <div class="collapse" id="comments_count_{{$post->id}}">
                            <div class="well">
                                comments_count
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{$posts->links()}}

    </div><!-- /.blog-main -->
</div>
@endsection