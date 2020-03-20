<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers;

use Bambamboole\LaravelCms\Users\Http\Requests\CreateUserRequest;
use Bambamboole\LaravelCms\Users\Http\Requests\UpdateUserRequest;
use Bambamboole\LaravelCms\Auth\Mails\NewUserCreatedMail;
use Bambamboole\LaravelCms\Auth\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UsersController
{
    public function index()
    {
        return Inertia::render('Users/Index', ['users' => User::all()]);
    }

    public function show(User $user)
    {
        return Inertia::render('Users/Show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::users.toast.updated', ['user' => $user->name]),
        ]);

        return Redirect::route('cms.backend.users.show', ['user' => $user]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', ['user' => new User()]);
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create(array_merge([
            'password' => $password = Str::random(), ],
            $request->validated()
        ));

        Mail::to($user->email)->send(new NewUserCreatedMail($password));

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::users.toast.created', ['user' => $user->name]),
        ]);

        return Redirect::route('cms.backend.users.show', ['user' => $user]);
    }
}
