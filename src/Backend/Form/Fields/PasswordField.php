<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

class PasswordField extends Field
{
    public string $component = 'PasswordField';

    public bool $confirm = true;

    public array $confirmAttributes = [
        'name' => 'password_confirmation',
        'label' => 'Confirm password',
    ];

    protected array $with = ['confirm', 'confirmAttributes'];

    public function jsonSerialize()
    {
        return array_merge(
            parent::jsonSerialize(),
            ['value' => '']
        );
    }
}
