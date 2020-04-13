<?php

namespace Bambamboole\LaravelCms\Core\Pages\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Form\Fields\MarkdownField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Pages\Models\Page;
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
                ->rules(['required']),
        ]);
    }
}
