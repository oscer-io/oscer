<?php

namespace Bambamboole\LaravelCms\Backend\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Form\Fields\PasswordField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextareaField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Core\Users\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class UserResource extends Resource
{
    public static string $model = User::class;

    public function fields(): Collection
    {
        return collect([
            ImageField::make('avatar')
                ->rules(['filled', 'image'])
                ->disk('public')
                ->folder('avatars')
                ->rounded(),
            TextField::make('name')
                ->rulesForCreate(['required', 'string'])
                ->rulesForUpdate(['filled', 'string']),
            TextField::make('email')
                ->rulesForCreate(['required', 'email', 'unique:cms_users,email'])
                ->rulesForUpdate([
                    'filled',
                    'email',
                    Rule::unique('cms_users', 'email')
                        ->ignore($this->resourceModel->id),
                ]),
            TextareaField::make('bio', 'Biography'),
            PasswordField::make('password')
                ->rules(['filled', 'confirmed']),
        ]);
    }
}