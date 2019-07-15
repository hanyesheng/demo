
@foreach($topics as $topic)
    <li><a href="/topic/{{$topic->id}}"><span class="@if($loop->index <= 2) text-danger @else text-warning @endif">{{$loop->index+1}}.</span> #{{$topic->name}}#<span class="label label-warning">{{$topic->posts_count}}</span></a></li>

@endforeach