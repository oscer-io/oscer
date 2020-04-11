<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

class SelectListField extends Field
{
    public string $component = 'select-list-field';

    protected array $options = [];

    protected array $with = ['options'];

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
