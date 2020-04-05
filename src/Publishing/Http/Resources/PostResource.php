<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\MarkdownField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TagsField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Http\Resources\BackendResource;
use Bambamboole\LaravelCms\Publishing\Models\Tag;
use Bambamboole\LaravelCms\Core\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;

class PostResource extends BackendResource
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
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => new \Bambamboole\LaravelCms\Core\Http\Resources\UserResource($this->whenLoaded('author')),
            'tags' => $this->whenLoaded('tags') instanceof MissingValue
                ? []
                : $this->whenLoaded('tags')->pluck('name'),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function fields(Request $request): Collection
    {
        return collect([
            TextField::make('name'),
            TextField::make('slug'),
            MarkdownField::make('body'),
            TagsField::make('tags')->suggestions(Tag::all()->pluck('name')->toArray()),
        ]);
    }
}
