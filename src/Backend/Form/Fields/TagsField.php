<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

class TagsField extends Field
{
    public string $component = 'TagsField';

    public array $suggestions = [];

    protected array $with = ['suggestions'];

    public function suggestions(array $suggestions)
    {
        $this->suggestions = $suggestions;

        return $this;
    }
}
