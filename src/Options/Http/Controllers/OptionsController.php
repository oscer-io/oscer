<?php

namespace Bambamboole\LaravelCms\Options\Http\Controllers;

use Bambamboole\LaravelCms\Options\Http\Requests\CreateOrUpdateOptionRequest;
use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Options\OptionRepository;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OptionsController
{
    protected OptionRepository $resolver;

    public function __construct(OptionRepository $resolver)
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
