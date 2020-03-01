<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

class PagesController
{
    public function index()
    {
        return view('cms::pages.index');
    }
}
