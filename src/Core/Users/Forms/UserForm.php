<?php

namespace Bambamboole\LaravelCms\Core\Users\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\PasswordField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextareaField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Mails\NewUserCreatedMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserForm extends Form
{
    protected string $password;

    public function fields(): Collection
    {
        return collect([
            TextField::make('name')
                ->rulesOnCreate(['required', 'string'])
                ->rulesOnUpdate(['filled', 'string']),
            TextField::make('email')
                ->rulesOnCreate(['required', 'email', 'unique:cms_users,email'])
                ->rulesOnUpdate([
                    'filled',
                    'email',
                    Rule::unique('cms_users', 'email')
                        ->ignore($this->resource ? $this->resource->id : null),
                ]),
            TextareaField::make('bio', 'Biography'),
            PasswordField::make('password')->rules(['filled', 'confirmed'])->doNotShowOnCreate(),
        ]);
    }

    public function afterValidation(array $data): array
    {
        if ($this->isCreateForm) {
            $this->password = Str::random();

            return array_merge(['password' => $this->password], $data);
        }

        return $data;
    }

    public function afterCreate($user)
    {
        Mail::to($user->email)->send(new NewUserCreatedMail($this->password));
    }
}
