@extends('cms::layouts.app', ['title' => 'Edit: '.$user->name])


@section('content')

    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                Edit: {{$user->name}}
            </h2>
        </div>
        <div class="mt-5 flex lg:mt-0 lg:ml-4">
    <span class="shadow-sm rounded-md">
      <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:shadow-outline focus:border-blue-300 transition duration-150 ease-in-out">
        Delete
      </button>
    </span>


            <span class="sm:ml-3 shadow-sm rounded-md">
      <a href="{{route('cms.users.edit', $user)}}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
        </svg>
        Save
      </a>
    </span>
        </div>
    </div>
@endsection
