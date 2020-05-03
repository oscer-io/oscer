<?php

namespace Oscer\Cms\Api\Http\Controllers;

use Oscer\Cms\Api\Http\Requests\SaveMenuOrderRequest;
use Oscer\Cms\Core\Models\Menu;
use Oscer\Cms\Core\Models\MenuItem;

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
