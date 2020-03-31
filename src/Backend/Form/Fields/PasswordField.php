<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

class PasswordField extends Field
{
    public string $component = 'password-field';

    public bool $confirm = true;

    public array $confirmAttributes = [
        'name' => 'password_confirmation',
        'label' => 'Confirm password',
    ];

    protected array $with = ['confirm', 'confirmAttributes'];
}
