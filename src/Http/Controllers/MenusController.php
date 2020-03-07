<?php

namespace Bambamboole\LaravelCms\Http\Controllers;

use Bambamboole\LaravelCms\Http\Requests\CreateMenuItemRequest;
use Bambamboole\LaravelCms\Http\Requests\SaveMenuOrderRequest;
use Bambamboole\LaravelCms\Http\Requests\UpdateMenuItemRequest;
use Bambamboole\LaravelCms\Models\Menu;
use Bambamboole\LaravelCms\Models\MenuItem;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenusController
{
    public function index()
    {
        return Inertia::render('Menus/Index', ['menus' => Menu::all()]);
    }

    public function show(string $name)
    {
        return Inertia::render('Menus/Show', ['menu' => Menu::resolve($name)]);
    }

    public function store(CreateMenuItemRequest $request, string $name)
    {
        MenuItem::query()->create(
            array_merge(
                [
                    'menu' => $name,
                    'order' => MenuItem::query()->where('menu', $name)->count() + 1,
                ],
                $request->validated()
            )
        );

        session()->flash('message', ['type' => 'success', 'text' => 'Menu item created']);

        return Redirect::route('cms.menus.show', ['name' => $name]);
    }

    public function saveOrder(SaveMenuOrderRequest $request, string $name)
    {
        // this is n+1 query and should be refactored
        foreach ($request->validated()['order'] as $item) {
            MenuItem::query()
                ->where('menu', $name)
                ->where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        session()->flash('message', ['type' => 'success', 'text' => 'Menu reordered']);

        return Redirect::route('cms.menus.show', ['name' => $name]);
    }

    public function delete(int $itemId)
    {
        $item = MenuItem::query()->find($itemId);
        $item->delete();

        session()->flash('message', ['type' => 'success', 'text' => 'Menu item deleted']);

        return Redirect::route('cms.menus.show', ['name' => $item->menu]);
    }

    public function update(UpdateMenuItemRequest $request, int $itemId)
    {
        $item = MenuItem::query()->find($itemId);
        $item->update($request->validated());

        session()->flash('message', ['type' => 'success', 'text' => 'Menu item updated']);

        return Redirect::route('cms.menus.show', ['name' => $item->menu]);
    }
}
