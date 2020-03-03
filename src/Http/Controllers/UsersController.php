<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

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
}
