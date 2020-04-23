<?php

namespace Oscer\Cms\Core\Users\Resources;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Oscer\Cms\Backend\Resources\Fields\ImageField;
use Oscer\Cms\Backend\Resources\Fields\PasswordField;
use Oscer\Cms\Backend\Resources\Fields\SelectField;
use Oscer\Cms\Backend\Resources\Fields\TextareaField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Users\Models\User;

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
                ->rules(['filled', 'confirmed'])->hideOnIndex(),
            SelectField::make('language')->options(['en', 'de']),
        ]);
    }
}
