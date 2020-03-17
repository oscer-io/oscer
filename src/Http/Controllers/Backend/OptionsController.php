<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

use Bambamboole\LaravelCms\Services\OptionFieldsResolver;
use Illuminate\Http\Request;

class OptionsController
{
    protected OptionFieldsResolver $resolver;

    public function __construct(OptionFieldsResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function index()
    {
        return $this->resolver->getOptionFields();
    }

    public function store(Request $request)
    {
        $data = [
            'key' => 'pages/front_page',
            'value' => 'a-page-slug',
        ];
    }
}
