@extends('cms::auth.layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <img class="mx-auto h-12 w-auto" src="/vendor/cms/workflow-mark-on-white.svg" alt="Workflow"/>
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    {{__('cms::auth.pages.login.title')}}

                </h2>

                @if ($errors->any())
                    <div class="text-center my-4">
                        <div class="my-3 text-center">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md relative"
                                 role="alert">
                                @if ($errors->has('email'))
                                    <span class="font-semibold">{{ $errors->first('email') }}</span>
                                @else
                                    <span class="font-semibold">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if(session()->has('loggedOut'))
                            <div class="text-center my-4">
                                <div
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md relative"
                                    role="alert">
                                    <span class="font-semibold">{{__('cms::auth.pages.login.logged_out')}}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <form class="mt-4" method="POST" action="{{route('cms.auth.attempt')}}">
                        @csrf

                        <div class="rounded-md shadow-sm">
                            <div>
                                <input aria-label="Email address" name="email" type="email" required
                                       class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                                       placeholder="Email address"/>
                            </div>
                            <div class="-mt-px">
                                <input aria-label="Password" name="password" type="password" required
                                       class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5"
                                       placeholder="Password"/>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" type="checkbox"
                                       class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                                <label for="remember" class="ml-2 block text-sm leading-5 text-gray-900">
                                    {{__('cms::auth.pages.login.remember')}}
                                </label>
                            </div>

                            <div class="text-sm leading-5">
                                <a href="{{route('cms.password.forgot')}}"
                                   class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                    {{__('cms::auth.pages.login.forgot')}}

                                </a>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
              <span class="absolute left-0 inset-y pl-3">
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400 transition ease-in-out duration-150"
                     fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd"/>
                </svg>
              </span>
                                {{__('cms::auth.pages.login.login')}}
                            </button>
                        </div>
                    </form>
            </div>
        </div>



@endsection
