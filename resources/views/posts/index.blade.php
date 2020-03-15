@extends('cms::layouts.default', ['title' => 'Posts overview'])

@section('content')
    @forelse($posts as $post)
        <article>
            <h2><a href="{{ route('cms.posts.show', $post->slug) }}">{{$post->name}}</a></h2>
        </article>
    @empty
        <p>No posts available</p>
    @endforelse
@endsection
