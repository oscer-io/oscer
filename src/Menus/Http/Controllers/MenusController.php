<?php

namespace Bambamboole\LaravelCms\Menus\Http\Controllers;

use Bambamboole\LaravelCms\Menus\Http\Requests\CreateMenuItemRequest;
use Bambamboole\LaravelCms\Menus\Http\Requests\UpdateMenuItemRequest;
use Bambamboole\LaravelCms\Menus\Models\Menu;
use Bambamboole\LaravelCms\Menus\Models\MenuItem;

class MenusController
{
    public function index()
    {
        return ['data' => Menu::all()];
    }

    public function show(string $name)
    {
        return ['data' => Menu::resolve($name)];
    }

    public function store(CreateMenuItemRequest $request, string $name)
    {
        MenuItem::query()->create(
            array_merge(
                [
                    'menu'  => $name,
                    'order' => MenuItem::query()->where('menu', $name)->count() + 1,
                ],
                $request->validated()
            )
        );

        return ['data' => Menu::resolve($name)];
    }

    public function update(UpdateMenuItemRequest $request, string $name, int $itemId)
    {
        $item = MenuItem::query()->where('menu', $name)->findOrFail($itemId);
        $item->update($request->validated());

        return $item;
    }

    public function delete(string $name, int $itemId)
    {
        $item = MenuItem::query()->where('menu', $name)->findOrFail($itemId);
        $item->delete();

        return ['success' => true];
    }
}
