<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\CmsUser;
use Inertia\Inertia;

class UsersController
{
    public function index()
    {
        return Inertia::render('Users/Index', ['users' => CmsUser::all()]);
    }

    public function show(CmsUser $user)
    {
        return Inertia::render('Users/Show', ['user' => $user]);
    }
}
