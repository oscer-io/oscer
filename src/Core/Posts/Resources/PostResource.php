<?php

namespace Oscer\Cms\Core\Posts\Resources;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Elements\Card;
use Oscer\Cms\Backend\Resources\Fields\Field;
use Oscer\Cms\Backend\Resources\Fields\ImageField;
use Oscer\Cms\Backend\Resources\Fields\MarkdownField;
use Oscer\Cms\Backend\Resources\Fields\TagsField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Posts\Models\Post;
use Oscer\Cms\Core\Posts\Models\Tag;

class PostResource extends Resource
{
    public static string $model = Post::class;

    protected array $additionalValidationRules = ['tags.*' => ['string']];

    public function fields(): Collection
    {
        return collect([
            new Card('first', [
                ImageField::make('featured_image', 'Featured Image')
                    ->rules(['filled'])
                    ->disk('public')
                    ->folder('images'),
                TextField::make('name')
                    ->rules(['required', 'string']),
                TextField::make('slug')
                    ->rules(['filled', 'string']),
            ], '1/2'),
            new Card('test', [
                MarkdownField::make('body')
                    ->rules(['required'])->hideOnIndex(),
                TagsField::make('tags', 'Tags', function (Field $field) {
                    return $field->model->tags->pluck('name');
                })->suggestions(Tag::all()->pluck('name')->toArray())->rules(['array']),
            ], '1/2'),
        ]);
    }
}
