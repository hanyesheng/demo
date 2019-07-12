@extends("layout.main")
@section("content")
<div class="col-sm-8">
    <blockquote>
        <p>{{$topic->name}}</p>
        <footer>文章：{{$topic->post_topics_count}}</footer>
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


