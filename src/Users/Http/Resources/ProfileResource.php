<?php

namespace Bambamboole\LaravelCms\Users\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\PasswordField;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProfileResource extends UserResource
{
    public function fields(Request $request): Collection
    {
        return parent::fields($request)->merge([
            PasswordField::make('password','Password', false)
        ]);
    }
}
