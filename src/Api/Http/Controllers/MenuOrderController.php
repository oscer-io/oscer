<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Bambamboole\LaravelCms\Api\Http\Requests\SaveMenuOrderRequest;
use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;

class MenuOrderController
{
    public function update(SaveMenuOrderRequest $request, int $id)
    {
        // this is n+1 query and should be refactored
        foreach ($request->validated()['order'] as $item) {
            MenuItem::query()
                ->where('menu_id', $id)
                ->where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return ['data' => Menu::query()->findOrFail($id)];
    }
}
