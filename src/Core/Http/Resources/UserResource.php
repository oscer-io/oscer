<?php

namespace Bambamboole\LaravelCms\Core\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextareaField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Http\Resources\BackendResource;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserResource extends BackendResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
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

    public function fields(Request $request): Collection
    {
        return collect([
            TextField::make('name'),
            TextField::make('email'),
            TextareaField::make('bio', 'Biography'),
        ]);
    }
}
