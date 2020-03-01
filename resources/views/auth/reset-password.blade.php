@extends('cms::layouts.logged-out')

@section('content')
    <div class="container mt-20">
        <div class="xl:w-1/2 mx-auto">
            <div class="flex items-center mb-10">
                <h2 class="font-normal">Your New Password</h2>
            </div>

            <p class="mb-5 leading-normal">Copy your new password, use it for your
                <a class="text-primary no-underline" href="{{route('cms.auth.login')}}">next login</a>, and then reset
                it.
            </p>

            <span class="bg-lighter text-sm p-1">{{$password}}</span>
        </div>
    </div>
@endsection
