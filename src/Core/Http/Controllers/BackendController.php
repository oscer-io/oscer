<?php

namespace Bambamboole\LaravelCms\Core\Http\Controllers;

use Illuminate\Http\Request;

class BackendController
{
    public function __invoke(Request $request)
    {
        return view('cms::backend', [
            'user' => $request->user(),
        ]);
    }
}
