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
