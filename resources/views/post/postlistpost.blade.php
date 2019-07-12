<div class="">
    {{$post->id}}.
    <a href="/user/{{$post->user->id}}">{{$post->user->assumed_name}} </a><small class="text-muted">{{$post->created_at->diffForHumans()}} </small>:
    {{$post->title}}
    @if($post->avatar)<a href="{{$post->avatar}}" >查看图片</a>@endif
@include('post.postlist')
</div>