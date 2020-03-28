@extends('cms::themes.default.layout', ['title' => $page->name])

@section('content')
    <h1>{{$page->name}}</h1>
    <div>
        {!! $page->getRenderedBody() !!}
    </div>
@endsection
