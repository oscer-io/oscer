@extends('cms::layouts.default', ['title' => $post->name])

@section('content')
    <article>
        <h1>{{$post->name}}</h1>
        <div>
            {!! $post->body !!}
        </div>
    </article>
@endsection
