<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

class SwaggerUiController
{
    public function __invoke()
    {
        return view('cms::swagger-ui');
    }
}
