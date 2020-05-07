<?php

namespace Oscer\Cms\Backend\Resources;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\ImageField;
use Oscer\Cms\Backend\Resources\Fields\MarkdownField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Core\Models\Page;

class PageResource extends Resource
{
    public static string $model = Page::class;

    public static array $searchColumns = ['name', 'slug', 'body'];

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
                ->rules(['required'])->hideOnIndex(),
        ]);
    }
}
