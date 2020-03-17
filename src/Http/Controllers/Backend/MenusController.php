<?php

namespace Bambamboole\LaravelCms\Http\Controllers\Backend;

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
        $item = MenuItem::query()->create(
            array_merge(
                [
                    'menu'  => $name,
                    'order' => MenuItem::query()->where('menu', $name)->count() + 1,
                ],
                $request->validated()
            )
        );

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::menus.toast.item_created', ['item' => $item->name])
        ]);

        return Redirect::route('cms.backend.menus.show', ['name' => $name]);
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

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::menus.toast.reordered')
        ]);

        return Redirect::route('cms.backend.menus.show', ['name' => $name]);
    }

    public function delete(int $itemId)
    {
        $item = MenuItem::query()->find($itemId);
        $item->delete();

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::menus.toast.item_deleted', ['item' => $item->name])
        ]);

        return Redirect::route('cms.backend.menus.show', ['name' => $item->menu]);
    }

    public function update(UpdateMenuItemRequest $request, int $itemId)
    {
        $item = MenuItem::query()->find($itemId);
        $item->update($request->validated());

        session()->flash('message', [
            'type' => 'success',
            'text' => __('cms::menus.toast.item_updated', ['item' => $item->name])
        ]);

        return Redirect::route('cms.backend.menus.show', ['name' => $item->menu]);
    }
}
