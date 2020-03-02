@extends('cms::layouts.app', ['title' => $user->name])

@section('content')

    @livewire(Bambamboole\LaravelCms\Http\Livewire\Profile::class)

@endsection
