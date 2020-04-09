<?php

namespace Bambamboole\LaravelCms\Core\Pages\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Form\Fields\MarkdownField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Support\Collection;

class PageForm extends Form
{
    public function fields(): Collection
    {
        return collect([
            ImageField::make('featured_image', 'Featured Image')->disk('public')->folder('images'),
            TextField::make('name')->rules(['required', 'string']),
            TextField::make('slug')->rules(['filled', 'string']),
            MarkdownField::make('body')->rules(['required']),
        ]);
    }
}
