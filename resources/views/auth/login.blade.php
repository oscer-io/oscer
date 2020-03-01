@extends('cms::layouts.logged-out')

@section('content')
    <div class="container mt-20">
        <div class="xl:w-1/2 mx-auto">
            <div class="flex items-center mb-10">
                <h2 class="font-normal">Log In</h2>
            </div>

            @if ($errors->any())
                <div class="font-semibold text-red mb-4">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @else
                        {{ $errors->first('password') }}
                    @endif
                </div>
            @endif

            @if(session()->has('loggedOut'))
                <div class="font-semibold text-green mb-4">
                    You've been logged out.
                </div>
            @endif

            <form method="POST" action="{{route('cms.auth.attempt')}}">
                @csrf

                <div class="input-group">
                    <label for="email" class="input-label">Email Address</label>
                    <input type="email" class="input"
                           name="email" id="email"
                           placeholder="mail@example.com">
                </div>

                <div class="input-group mb-5">
                    <label for="password" class="input-label">Password</label>
                    <input type="password" class="input"
                           name="password" id="password"
                           placeholder="******">
                </div>

                <div class="flex items-center mb-10">
                    <div class="flex items-center mr-auto">
                        <input type="checkbox" class="-mt-1 mr-2" id="remember" name="remember">
                        <label for="remember">Remember Me</label>
                    </div>

                                    <a href="{{route('cms.password.forgot')}}" class="no-underline text-primary">Forgot your password?</a>
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>
        </div>
    </div>
@endsection
