@extends("layout.main")

@section("content")
    <div class="col-sm-8">
        <blockquote>
            <p><img src="{{$user->avatar}}" alt="" class="img-rounded" style="border-radius:500px; height: 40px"> {{$user->name}}
            </p>


            <footer>关注：{{$user->stars_count}}｜粉丝：{{$user->fans_count}}｜文章：{{$user->posts_count}}</footer>
            @include('user.badges.like', ['target_user' => $user])
        </blockquote>
        <div class="col-sm-12 blog-main">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">关注</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">粉丝</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        @foreach($countposts as $post)
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
                                                <div class="post-content"><p class="lead">{{$post->title}}</p></div>
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
                            {{--转发弹窗--}}
                            <div class="modal fade" id="reposts_count_{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <form action="/repost" method="POST" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                {{csrf_field()}}
                                                <input class="file-loading preview_input" type="hidden" value="{{$post->id}}"  style="width:72px" name="forward_post_id">
                                                <input class="file-loading preview_input" type="hidden" value="{{$post->original_post_id}}" style="width:72px" name="original_post_id">
                                                <input type="text" class="form-control" value="" name="title" placeholder="" aria-describedby="basic-addon2">
                                                <div class="jumbotron">
                                                    <div class="row">
                                                        <div class="form-group add-img">
                                                            <input class="file-loading preview_input" id="exampleInputFile" type="file" name="avatar">
                                                            <img  class="preview_img img-rounded" src="" alt="" class="img-rounded">
                                                        </div>
                                                        <div class="col-md-12">
                                                            // <a href="/user/{{$post->user->id}}">{{$post->user->assumed_name}}</a> : {{$post->title}}
                                                            @foreach($post->topics as $topic)
                                                                <a class="topic-font" href="/topic/{{$topic->id}}">#{{$topic->name}}#</a>
                                                                <input type="hidden" class="form-control" value="{{$topic->name}}" name="topic_name">
                                                            @endforeach
                                                        </div>
                                                        @if($post->avatar)
                                                            <div class="col-md-12"><img src="{{$post->avatar}}" alt="..." class="img-rounded post-img"></div>
                                                        @endif
                                                    </div>
                                                </div>
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
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        @foreach($susers as $user)
                        <div class="blog-post" style="margin-top: 30px">
                            <p class=""><a href="/user/{{$user->id}}">{{$user->name}}</a></p>
                            <p class="">关注：{{$user->stars_count}} | 粉丝：{{$user->fans_count}}｜ 文章：{{$user->posts_count}}</p>

                            @include('user.badges.like', ['target_user' => $user])

                        </div>
                        @endforeach
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        @foreach($fusers as $user)
                            <div class="blog-post" style="margin-top: 30px">
                                <p class=""><a href="/user/{{$user->id}}">{{$user->name}}</a></p>
                                <p class="">关注：{{$user->stars_count}} | 粉丝：{{$user->fans_count}}｜ 文章：{{$user->posts_count}}</p>

                                @include('user.badges.like', ['target_user' => $user])

                            </div>
                        @endforeach
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
@endsection