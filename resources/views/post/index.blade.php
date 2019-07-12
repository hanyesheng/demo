@extends("layout.main")
@section("content")
<div class="col-sm-8 blog-main">
    <div style="height: 20px;">
    </div>
    <div>
        @foreach($posts as $post)
            @include('post.post')
        @endforeach
        {{$posts->links()}}
    </div><!-- /.blog-main -->
</div>
@endsection