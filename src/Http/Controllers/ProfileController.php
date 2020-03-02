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
}
