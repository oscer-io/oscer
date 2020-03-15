@extends('cms::layouts.default', ['title' => $page->name])

@section('content')
    <h1>{{$page->name}}</h1>
    <div>
        {!! $page->body !!}
    </div>
@endsection
