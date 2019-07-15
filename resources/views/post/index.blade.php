@extends("layout.main")
@section("content")
<div class="col-sm-8 blog-main">
    @foreach($posts as $post)
        @include('post.post')
    @endforeach
    {{$posts->links()}}
</div>
@endsection