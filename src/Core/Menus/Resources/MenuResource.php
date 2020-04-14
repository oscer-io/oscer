<?php

namespace Bambamboole\LaravelCms\Core\Menus\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Illuminate\Support\Collection;

class MenuResource extends Resource
{
    public static string $model = Menu::class;

    public function fields(): Collection
    {
        return collect([
            TextField::make('name'),
            TextField::make('items')->hideOnIndex(),
        ]);
    }

    public function toArray()
    {
        return [
            'fields' => $this->fields,
            'model' => $this->resourceModel,
            'resourceId' => $this->resourceModel->name,
        ];
    }
}
