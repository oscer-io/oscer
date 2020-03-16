<?php


namespace Bambamboole\LaravelCms\Http\Controllers\Backend;


use Bambamboole\LaravelCms\Models\Option;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class OptionsController
{
    protected Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function index()
    {
        $options = Option::all()->toArray();
        $tabs = collect($this->config->get('cms.options'));
        $tabs = $tabs
            ->map(function ($fields, $tab) use ($options) {
                $fields = collect($fields)->map(function ($info, $name) use ($tab, $options) {
                    $key = "{$tab}/{$name}";
                    $info['value'] = collect($options)->first(function ($option) use ($key) {
                        return $option['key'] === $key;
                    })['value'];

                    return $info;
                })->toArray();
                return $fields;
            });

        return $tabs;
    }

    public function store(Request $request)
    {
        $data = [
            'key' => 'pages/front_page',
            'value' => 'a-page-slug',
        ];
    }
}
