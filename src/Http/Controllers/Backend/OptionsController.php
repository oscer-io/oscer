<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

use Bambamboole\LaravelCms\Http\Requests\CreateOrUpdateOptionRequest;
use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Services\OptionFieldsResolver;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OptionsController
{
    protected OptionFieldsResolver $resolver;

    public function __construct(OptionFieldsResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function index()
    {
        return Inertia::render('Options/Index', ['options' => $this->resolver->getOptionFields()]);
    }

    public function store(CreateOrUpdateOptionRequest $request)
    {
        $option = Option::query()->updateOrCreate(
            ['key' => $request->input('key')],
            ['value' => $request->input('value')]
        );

        session()->flash('message', ['type' => 'success', 'text' => "Option {$option->key} updated"]);

        return Redirect::route('cms.backend.options.index');
    }
}
