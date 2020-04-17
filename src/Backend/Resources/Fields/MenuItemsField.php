<?php

namespace Bambamboole\LaravelCms\Backend\Resources\Fields;

use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Closure;
use Illuminate\Http\Request;

class MenuItemsField extends Field
{
    public string $component = 'MenuItemsField';

    public function __construct(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null
    ) {
        $fillResourceCallback = $fillResourceCallback ?: function (Menu $model, Request $request) {
            $updatedItems = json_decode($request->input($this->name), true);
            foreach ($updatedItems as $updatedItem) {
                $model->items()
                    ->firstWhere('id', $updatedItem['id'])
                    ->update(['order' => $updatedItem['order']]);
            }
        };
        parent::__construct($name, $label, $resolveValueCallback, $fillResourceCallback);
    }
}
