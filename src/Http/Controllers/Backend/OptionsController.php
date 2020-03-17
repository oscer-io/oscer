<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

use Bambamboole\LaravelCms\Http\Requests\CreateOrUpdateOptionRequest;
use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Services\OptionFieldsResolver;

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

    public function store(CreateOrUpdateOptionRequest $request)
    {
        return Option::query()->updateOrCreate($request->validated());
    }
}
