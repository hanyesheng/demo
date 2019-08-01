<div class="media">
    <div class="avatar pull-left">
        <a href="/user/{{ $notification->data['zan_user_id'] }}">
        <img class="media-object img-thumbnail" alt="{{ $notification->data['zan_user_name'] }}" src="{{ $notification->data['zan_user_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="/user/{{ $notification->data['zan_user_id'] }}">{{ $notification->data['zan_user_name'] }}</a>
            赞了你

            {{-- 回复删除按钮 --}}
            <span class="meta pull-right" title="{{ $notification->created_at }}">
                <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="reply-content">
            [{{ $notification->data['orPosts_assumed_name'] }}]:{{ $notification->data['orPosts_title'] }}
        </div>
    </div>
</div>
<hr>