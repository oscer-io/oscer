<?php


namespace Bambamboole\LaravelCms\Http\Controllers;


class ProfileController
{
    public function show()
    {
        return view('cms::profile.show', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('cms::profile.edit', ['user' => auth()->user()]);
    }
}
