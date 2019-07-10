@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <form action="/posts" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <textarea id="title" name="title" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">添加图片</label>
            <div class="col-sm-10">
                <input class="file-loading preview_input" type="file"  style="width:72px" name="avatar">
                <img  class="preview_img" src="" alt="" class="img-rounded" style="border-radius:500px;">
            </div>
        </div>
        @include('layout.error')
        <button type="submit" class="btn btn-default">提交</button>
    </form>
    <br>

</div><!-- /.blog-main -->
@endsection