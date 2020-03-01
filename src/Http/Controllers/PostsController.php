<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

class PostsController
{
    public function index()
    {
        return view('cms::posts.index');
    }
}
