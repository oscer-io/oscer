<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class OpenApiController
{
    public function reference()
    {
        $definition = Yaml::parseFile(__DIR__.'/../../../../resources/open-api/reference/laravel-cms.yaml');

        $definition['servers'] = [
            ['url' => 'http://'.config('cms.backend.domain').'/api/cms'],
        ];

        return Yaml::dump($definition);
    }

    public function file(string $folder, string $file)
    {
        $content = File::get(__DIR__."/../../../../resources/open-api/{$folder}/{$file}");

        return $content;
    }
}
