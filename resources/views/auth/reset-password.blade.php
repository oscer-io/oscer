@extends('cms::auth.layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <img class="mx-auto h-12 w-auto" src="/vendor/cms/workflow-mark-on-white.svg" alt="Workflow"/>
                <h2 class="my-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    {{__('cms::auth.pages.new_password.title')}}
                </h2>

            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md relative"
                     role="alert">
                    <ul class="list-disc">
                        @foreach ($errors->all() as $error)
                            <li class="ml-3">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
