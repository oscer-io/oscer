<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers;

use Bambamboole\LaravelCms\Users\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Redirect;
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

        session()->flash('message', [
            'type' => 'success',
            'text' =>  __('cms::profile.toast.updated'),
        ]);

        return Redirect::route('cms.backend.profile.show');
    }
}