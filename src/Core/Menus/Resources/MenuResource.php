<?php

namespace Oscer\Cms\Core\Menus\Resources;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\MenuItemsField;
use Oscer\Cms\Backend\Resources\Fields\SelectField;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Menus\Models\Menu;
use Oscer\Cms\Frontend\Contracts\Theme;

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

    protected function hasDetailView(): bool
    {
        return false;
    }
}
