<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Models\CmsUser;

class UsersController
{
    public function index()
    {
        return view('cms::users.index', ['users' => CmsUser::all()]);
    }

    public function show(CmsUser $user)
    {
        return view('cms::users.show', ['user' => $user]);
    }

    public function edit(CmsUser $user)
    {
        return view('cms::users.edit', ['user' => $user]);
    }

    public function create(CmsUser $user)
    {
        return view('cms::users.create', ['user' => $user]);
    }
}
