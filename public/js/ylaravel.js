$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var E = window.wangEditor;
var editor = new E('#contentEditor');
// 配置服务器端地址
editor.customConfig.uploadImgServer = '/posts/image/upload';

// 设置文件的name值
editor.customConfig.uploadFileName = 'wangEditorH5File';

// 限制图片大小为1M
editor.customConfig.uploadImgMaxSize = 1 * 1024 * 1024;

editor.customConfig.uploadImgHeaders = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
};

editor.customConfig.uploadImgHooks = {
    customInsert: function (insertImg, result, editor) {
        var url = result.data;
        //上传图片回填富文本编辑器
        insertImg(url);
    }
};

var $text1 = $('#content');
editor.customConfig.onchange = function (html) {
    // 监控变化，同步更新到 textarea
    $text1.val(html)
};
editor.create();
// 初始化 textarea 的值
$text1.val(editor.txt.html());

// 上传头像图片预览
$(".preview_input").change(function(event){
    var file = event.currentTarget.files[0];
    var url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img").attr("src", url);
});

$(".like-button").click(function(event){
    var target = $(event.target);
    var current_like = target.attr('like-value');
    var user_id = target.attr("like-user");
    if (current_like == 1) {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/unfan",
            method : 'POST',
            dataType: "json",
            success: function(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 0);
                target.text("关注")
            }
        })
    } else {
        // 关注
        $.ajax({
            url: "/user/" + user_id + "/fan",
            method : 'POST',
            dataType: "json",
            success: function(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 1);
                target.text("取消关注")
            }
        })
    }
});
function Open_File()
{
    document.getElementById("btn_file").click();
};