

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>注册:摩西摩西~(￣▽￣)／ もしもし</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://v3.bootcss.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/signin/signin.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="/logo.png" sizes="32x32">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <form class="form-signin" method="POST" action="/register">
        <div class="col-md-6 col-md-offset-3" style="padding-bottom: 15px;">
            <img src="/logo_big.png" alt="..." class="img-responsive">
        </div>
        {{ csrf_field() }}
        <label for="username" class="sr-only">登录名</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="登录名" required autofocus>
        <label for="name" class="sr-only">昵称</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="名字" required autofocus>
        <label for="inputEmail" class="sr-only">邮箱</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="输入密码" required>
        <label class="sr-only">重复密码</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="重复输入密码" required>

        @include('layout.error')
        <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
        <a href="/login" class="btn btn-lg btn-primary btn-block">已有账号？去登陆─=≡Σ(((つ•̀ω•́)つ</a>
        <a href="/" class="btn btn-lg btn-primary btn-link btn-block text-center">随便逛逛(￢_￢)</a>
    </form>

</div> <!-- /container -->

</body>
</html>
