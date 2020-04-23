<?php

namespace Oscer\Cms\Core\Pages\Resources;

use Oscer\Cms\Backend\Resources\Fields\ImageField;
use Oscer\Cms\Backend\Resources\Fields\MarkdownField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Pages\Models\Page;
use Illuminate\Support\Collection;

class PageResource extends Resource
{
    public static string $model = Page::class;

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
