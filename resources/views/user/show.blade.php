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
                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">关注</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">粉丝</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">话题</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        @foreach($countposts as $post)
                            @include('post.post')
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
                    <div class="tab-pane" id="tab_4">
                        @foreach($sutopics as $topic)
                            <div class="pull-left" style="margin-right: 10px">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <a href="/topic/{{$topic->id}}" style="white-space: nowrap">#{{$topic->name}}#</a><br>
                                        <span>
                                        内容：{{$topic->posts_count}} | 关注：<span class="users_count">{{$topic->users_count}}</span>|
                                            @if ($topic->usertopic(\Auth::id())->exists())
                                                <a class="add-topic-button" add-value="1" add-topic="{{$topic->id}}" href="javascript:void(0);">√取消关注</a>
                                            @else
                                                <a class="add-topic-button" add-value="0" add-topic="{{$topic->id}}" href="javascript:void(0);">＋关注</a>
                                            @endif
                                        </span>
                                    </div>
                                </div>
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