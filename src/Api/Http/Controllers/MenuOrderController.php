<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Bambamboole\LaravelCms\Api\Http\Requests\SaveMenuOrderRequest;
use Bambamboole\LaravelCms\Menus\Models\Menu;
use Bambamboole\LaravelCms\Menus\Models\MenuItem;

class MenuOrderController
{
    public function update(SaveMenuOrderRequest $request, string $name)
    {
        // this is n+1 query and should be refactored
        foreach ($request->validated()['order'] as $item) {
            MenuItem::query()
                ->where('menu', $name)
                ->where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return ['data' => Menu::resolve($name)];
    }
}
