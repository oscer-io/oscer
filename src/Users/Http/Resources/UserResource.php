<?php

namespace Bambamboole\LaravelCms\Users\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextareaField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Http\Resources\BackendResource;

class UserResource extends BackendResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'language' => $this->language,
        ];
    }

    public function fields()
    {
        return collect([
            TextField::make('name'),
            TextField::make('email'),
            TextareaField::make('bio', 'Biography'),
        ]);
    }
}
