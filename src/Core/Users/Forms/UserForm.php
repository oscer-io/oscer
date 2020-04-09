<?php

namespace Bambamboole\LaravelCms\Core\Users\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Form\Fields\PasswordField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextareaField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class UserForm extends Form
{
    protected string $password;

    public function fields(): Collection
    {
        return collect([
            ImageField::make('avatar')
                ->rules(['filled', 'image'])
                ->disk('public')
                ->folder('avatars'),
            TextField::make('name')
                ->rulesOnCreate(['required', 'string'])
                ->rulesOnUpdate(['filled', 'string']),
            TextField::make('email')
                ->rulesOnCreate(['required', 'email', 'unique:cms_users,email'])
                ->rulesOnUpdate([
                    'filled',
                    'email',
                    Rule::unique('cms_users', 'email')
                        ->ignore($this->resource->id),
                ]),
            TextareaField::make('bio', 'Biography'),
            PasswordField::make('password')
                ->rulesOnUpdate(['filled', 'confirmed']),
        ]);
    }
}
