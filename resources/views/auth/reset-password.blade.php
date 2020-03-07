@extends('cms::layouts.logged-out')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <img class="mx-auto h-12 w-auto" src="/vendor/cms/workflow-mark-on-white.svg" alt="Workflow"/>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    {{__('cms::auth.pages.new_password.title')}}
                </h2>

            </div>
            <div class="text-center mt-8">

                <div class="py-6">

                    <span class="bg-gray-700 rounded text-sm py-2 px-6 text-white">{{$password}}</span>
                </div>
                <p>{{__('cms::auth.pages.new_password.text')}}</p>
                <div class="mt-10">
                    <a href="{{route('cms.auth.login')}}"
                       class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        {{__('cms::auth.pages.new_password.goto')}}

                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
