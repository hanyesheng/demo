@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <form class="form-horizontal" action="/user/me/settingImage" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" value="avatar" name="type">
        <div class="form-group">
            <label class="col-sm-2 control-label">头像</label>
            <div class="col-sm-2">
                <input class=" file-loading preview_input" type="file" value="头像" style="width:72px" name="avatar">
                <img  class="preview_img" src="{{$user->image->path ?? NULL}}" alt="" class="img-rounded" style="border-radius:500px;">
            </div>
        </div>
        <button type="submit" class="btn btn-default">修改头像</button>
    </form>
    <form class="form-horizontal" action="/user/me/createAssumedName" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">花名</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control" name="assumed_name" disabled value="{{$user->assumed_name}}">
                    <span class="input-group-addon">剩余机会：{{$user->dice_id}}</span>
                    <input type="hidden" class="form-control" name="dice_id" value="{{$user->dice_id}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" @if ($user->dice_id == 0) disabled="disabled" @endif type="button"><span class="glyphicon glyphicon-repeat"></span></button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>
    </form>
    <form class="form-horizontal1" action="/user/me/setting" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">名字</label>
            <div class="col-sm-10">
                <input class="form-control" name="name" type="text" value="{{$user->name}}">
            </div>
        </div>
        <button type="submit" class="btn btn-default">修改</button>
    </form>
    <br>
</div>

@endsection
