<?php

namespace Oscer\Cms\Backend\Resources;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\Field;
use Oscer\Cms\Backend\Resources\Fields\ImageField;
use Oscer\Cms\Backend\Resources\Fields\MarkdownField;
use Oscer\Cms\Backend\Resources\Fields\TagsField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Core\Models\Post;
use Oscer\Cms\Core\Models\Tag;

class PostResource extends Resource
{
    public static string $model = Post::class;

    protected array $additionalValidationRules = ['tags.*' => ['string']];

    public function fields(): Collection
    {
        return collect([
            new Card('first', [
                TextField::make('name')
                    ->rules(['required', 'string']),
                TextField::make('slug')
                    ->rules(['filled', 'string']),
                MarkdownField::make('body')
                    ->rules(['required'])->hideOnIndex(),
            ], '2/3'),
            new Card('test', [
                ImageField::make('featured_image', 'Featured Image')
                    ->rules(['filled'])
                    ->disk('public')
                    ->folder('images'),
                TagsField::make('tags', 'Tags', function (Field $field) {
                    return $field->model->tags->pluck('name');
                })->suggestions(Tag::all()->pluck('name')->toArray())->rules(['array']),
            ], '1/3'),
        ]);
    }
}
