<?php

namespace Bambamboole\LaravelCms\Core\Menus\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Support\Collection;

class MenuItemForm extends Form
{
    protected array $missingValues = ['menu'];

    public function fields(): Collection
    {
        return collect([
            TextField::make('name')->rules(['required', 'string']),
            TextField::make('url')->rules(['required', 'string']),
        ]);
    }
}
