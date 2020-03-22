<?php


namespace Bambamboole\LaravelCms\Core\Http\Controllers;


use Symfony\Component\Yaml\Yaml;

class GetOpenApiDefinitionController
{
    public function __invoke()
    {
        $definition = Yaml::parseFile(__DIR__.'/../../../../resources/open-api/reference/laravel-cms.yaml');

        $definition['servers'] = [
            ['url' => config('app.url') . '/api/cms']
        ];

        return Yaml::dump($definition);
    }
}
