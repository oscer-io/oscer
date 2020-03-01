@extends('cms::layouts.logged-out')

@section('content')
    <div class="container mt-20">
        <div class="xl:w-1/2 mx-auto">

            <div class="flex items-center mb-10">
                <h2 class="font-normal">Reset Password</h2>
            </div>

            @if ($errors->any())
                <div class="font-semibold text-red mb-4">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @endif
                </div>
            @endif

            @if(session()->has('invalidResetToken'))
                <div class="font-semibold text-red mb-4">
                    Invalid reset token.
                </div>
            @endif

            @if (session()->has('sent'))
                <div class="font-semibold text-success mb-4">
                    You should receive an email in a bit.
                </div>
            @endif

            <form method="POST" action="{{route('cms.password.email')}}">
                @csrf

                <div class="input-group mb-10">
                    <label for="email" class="input-label">Email Address</label>
                    <input type="email" class="input"
                           name="email" id="email"
                           placeholder="mail@example.com">
                </div>

                <button type="submit" class="btn-primary">Reset Password</button>
            </form>

        </div>
    </div>
@endsection
