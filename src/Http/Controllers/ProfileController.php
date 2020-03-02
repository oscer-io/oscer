<?php


namespace Bambamboole\LaravelCms\Http\Controllers;


use Inertia\Inertia;

class ProfileController
{
    public function show()
    {
        return Inertia::render('Profile', [
            'user' => auth()->user()->toArray(),
        ]);
    }

    public function edit()
    {
        return view('cms::profile.edit', ['user' => auth()->user()]);
    }
}
