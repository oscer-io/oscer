<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Http\Requests\UpdateProfileRequest;
use Inertia\Inertia;

class ProfileController
{
    public function show()
    {
        return Inertia::render('Profile/Show', [
            'user' => auth()->user()->toArray(),
        ]);
    }

    public function edit()
    {
        return Inertia::render('Profile/Edit', [
            'user' => auth()->user()->toArray(),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());

        session()->flash('message', ['type' => 'success', 'text' => 'Profile updated']);
        return Inertia::render('Profile/Show', [
            'user' => auth()->user()->toArray(),
        ]);
    }
}
