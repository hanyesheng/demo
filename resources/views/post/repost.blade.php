
<form action="/repost" method="POST" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-body">
            {{csrf_field()}}
            <input class="file-loading preview_input" type="hidden" value="{{$post->id}}" name="forward_post_id">
            <input class="file-loading preview_input" type="hidden" value="{{$post->level_id}}" name="level_id">
            <input class="file-loading preview_input" type="hidden" value="{{$post->original_post_id}}"  name="original_post_id">
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