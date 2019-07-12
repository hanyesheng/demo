
<form action="/posts" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="modal-content">
        <div class="modal-body">
            <div class="form-group">
                <textarea id="title" name="title" class="form-control"></textarea>
                <div class="input-group">
                    <span class="input-group-addon">#</span>
                    <input type="text" class="form-control" name="topic_name">
                    <span class="input-group-addon">#</span>
                </div>
            </div>
            <div class="form-group">
                <input class="file-loading preview_input" type="file"  style="width:72px" name="avatar">
                <img  class="preview_img" src="" alt="" style="border-radius:500px;">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </div>
</form>