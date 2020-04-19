<?php

namespace Bambamboole\LaravelCms\Core\Menus\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\MenuItemsField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\SelectField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Support\Collection;

class MenuResource extends Resource
{
    public static string $model = Menu::class;

    public function fields(): Collection
    {
        return collect([
            TextField::make('name'),
            // @TODO Only show not used locations and add some help text
            SelectField::make('location')
                ->options(collect(array_keys(app(Theme::class)->getMenus()))->map(function ($name) {
                    return [
                        'name' => $name,
                        'label' => $name,
                        'value' => $name,
                    ];
                })->toArray()),
            MenuItemsField::make('items', 'Menu items')->hideOnIndex(),
        ]);
    }

    public function labels()
    {

    }
}
