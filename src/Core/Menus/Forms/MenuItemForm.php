<?php

namespace Bambamboole\LaravelCms\Core\Menus\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuItemForm extends Form
{
    public function fields(): Collection
    {
        return collect([
            TextField::make('name')->rules(['required', 'string']),
            TextField::make('url')->rules(['required', 'string']),
        ]);
    }

    public function beforeSave(Request $request)
    {
        $this->resource->menu = $request->input('menu');
        $this->resource->order = $request->input('order');
    }
}
