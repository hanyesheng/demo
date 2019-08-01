@extends("layout.main")

@section("content")

    <div class="col-sm-8 blog-main">
        @foreach ($notifications as $notification)
            @include('notice.types._' . snake_case(class_basename($notification->type)))
        @endforeach
    </div><!-- /.blog-main -->


@endsection