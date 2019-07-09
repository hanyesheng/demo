<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="/logo_big.png" class="top-logo">
            <a class="navbar-brand" href="#">MoshiMoshi</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/posts">首页</a></li>
                <li><a href="/posts/create">发博</a></li>
                <li><a href="/notices">通知</a></li>
            </ul>
            <form action="/posts/search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="query" class="form-control" placeholder="搜索">
                </div>
                <button type="submit" class="btn btn-default">Go!</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
            @if (\Auth::check())
                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{\Auth::user()->avatar}}" alt="" class="img-rounded" style="border-radius:500px; height: 30px">{{ \Auth::user()->name }}  <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/user/{{\Auth::id()}}">我的主页</a></li>
                        <li><a href="/user/me/setting">个人设置</a></li>
                        <li><a href="/logout">登出</a></li>
                    </ul>
                </li>
            @else
                <li>
                    <a href="/login">登陆</a>
                </li>
                <li>
                    <a href="/register">注册</a>
                </li>
            @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>