<?php

namespace Bambamboole\LaravelCms\Core\Http\Controllers;

class SwaggerUiController
{
    public function __invoke()
    {
        return view('cms::swagger-ui');
    }
}
