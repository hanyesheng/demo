@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <form action="/posts/{{$post->id}}" method="POST">
        {{method_field("PUT")}}
        {{csrf_field()}}
        <div class="form-group">
            <label>标题</label>
            <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label>内容</label>
            <div id="contentEditor">
                <p>{!! $post->content !!}</p>
            </div>
            <textarea id="content" name="content" style="display: none" class="form-control"></textarea>
        </div>
        @include('layout.error')
        <button type="submit" class="btn btn-default">提交</button>
    </form>
    <br>
</div><!-- /.blog-main -->
@endsection
