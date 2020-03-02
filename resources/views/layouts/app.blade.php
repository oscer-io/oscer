@php($title = $title ?? 'No title passed to layout')
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel cms'). ' - '. $title }}</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>

    <!-- Styles -->
{{--    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">--}}
    <link href='{{asset('app.css', 'vendor/cms')}}' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="app">

    <div class="min-h-screen bg-white">
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block lg:hidden h-8 w-auto" src="/vendor/cms/workflow-mark-on-white.svg"
                                 alt=""/>
                            <img class="hidden lg:block h-8 w-auto" src="/vendor/cms/workflow-logo-on-white.svg"
                                 alt=""/>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex">
                            <a href="{{route('cms.posts.index')}}"
                               @if(\Illuminate\Support\Facades\Request::is(config('cms.backend.url'). '/posts*'))
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                @else
                                    class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                                    focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                                    ease-in-out">
                                @endif
                                Posts
                            </a>
                            <a href="{{route('cms.pages.index')}}"
                               @if(\Illuminate\Support\Facades\Request::is(config('cms.backend.url'). '/pages*'))
                               class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                @else
                                    class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                                    focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                                    ease-in-out">
                                @endif
                                Pages
                            </a>
                            <a href="{{route('cms.menus.index')}}"
                               @if(\Illuminate\Support\Facades\Request::is(config('cms.backend.url'). '/menus*'))
                               class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                @else
                                    class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                                    focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                                    ease-in-out">
                                @endif
                                Menus
                            </a>
                            <a href="{{route('cms.users.index')}}"
                               @if(\Illuminate\Support\Facades\Request::is(config('cms.backend.url'). '/users*'))
                               class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                @else
                                    class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                                    font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                                    focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                                    ease-in-out">
                                @endif
                                Users
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full"
                                         src="{{auth()->user()->avatar}}"
                                         alt=""/>
                                </button>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10">
                                <div class="py-1 rounded-md bg-white shadow-xs">
                                    <a href="{{route('cms.profile.show')}}"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Your
                                        Profile</a>
                                    <a href="{{route('cms.auth.logout')}}"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Sign
                                        out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3">
                    <a href="#"
                       class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out">Dashboard</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Team</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Projects</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Calendar</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                 src="{{auth()->user()->avatar}}"
                                 alt=""/>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-6 text-gray-800">{{auth()->user()->name}}</div>
                            <div class="text-sm font-medium leading-5 text-gray-500">{{auth()->user()->email}}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{route('cms.profile.show')}}"
                           class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Your
                            Profile</a>
                        <a href="{{route('cms.auth.logout')}}"
                           class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Sign
                            out</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-10">
            @if(isset($headline))
            <header>
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900">
                        {{$headline}}
                    </h2>
                </div>
            </header>
            @endif
            <main>
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</div>
</body>
</html>
