<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

class SelectField extends Field
{
    public string $component = 'select-field';

    public array $options = [];

    protected array $with = ['options'];

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
