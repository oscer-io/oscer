<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Illuminate\Http\Request;

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
