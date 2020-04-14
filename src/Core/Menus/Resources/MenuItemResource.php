<?php

namespace Bambamboole\LaravelCms\Core\Menus\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuItemResource extends Resource
{
    public static string $model = MenuItem::class;

    public function fields(): Collection
    {
        return collect([
            TextField::make('name')->rules(['required', 'string']),
            TextField::make('url')->rules(['required', 'string']),
        ]);
    }

    public function beforeSave(Request $request)
    {
        if ($request->route('id') === null) {
            $this->resourceModel->menu = $request->input('menu');
            $this->resourceModel->order = $request->input('order');
        }
    }
}
