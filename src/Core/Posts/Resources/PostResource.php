<?php

namespace Bambamboole\LaravelCms\Core\Posts\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\Field;
use Bambamboole\LaravelCms\Backend\Resources\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\MarkdownField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\TagsField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Core\Posts\Models\Tag;
use Illuminate\Support\Collection;

class PostResource extends Resource
{
    public static string $model = Post::class;

    protected array $additionalValidationRules = ['tags.*' => ['string']];

    public function fields(): Collection
    {
        return collect([
            ImageField::make('featured_image', 'Featured Image')
                ->rules(['filled'])
                ->disk('public')
                ->folder('images'),
            TextField::make('name')
                ->rules(['required', 'string']),
            TextField::make('slug')
                ->rules(['filled', 'string']),
            MarkdownField::make('body')
                ->rules(['required']),
            TagsField::make('tags', 'Tags', function (Field $field) {
                return $field->model->tags->pluck('name');
            })->suggestions(Tag::all()->pluck('name')->toArray())->rules(['array']),
        ]);
    }
}
