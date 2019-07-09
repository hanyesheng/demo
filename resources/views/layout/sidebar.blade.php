<div id="sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

    <aside class="widget panel panel-default">
        <div class="panel-heading">
            话题
        </div>

        <ul class="category-root list-group">
            @foreach($topics as $topic)
            <li class="list-group-item">
                <a href="/topic/{{$topic->id}}">#{{$topic->name}}#
                </a>
                <span class="badge">{{$topic->posts_count}}</span>
            </li>
            @endforeach
        </ul>
    </aside>
</div>