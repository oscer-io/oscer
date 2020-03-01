<?php


namespace Bambamboole\LaravelCms\Http\Controllers;


class DashboardController
{
    public function __invoke()
    {
        return view('cms::dashboard');
    }
}
