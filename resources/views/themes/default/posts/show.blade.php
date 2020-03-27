@extends('cms::themes.default.layout', ['title' => $post->name])

@section('content')
    <article>
        <h1>{{$post->name}}</h1>
        <div>
            {!! $post->getRenderedBody() !!}
        </div>
    </article>
@endsection
