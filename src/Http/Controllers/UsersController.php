<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Http\Requests\UpdateUserRequest;
use Bambamboole\LaravelCms\Models\User;
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

        session()->flash('message', ['type' => 'success', 'text' => "User {$user->name} updated"]);

        return Inertia::render('Users/Show', ['user' => $user]);
    }
}
