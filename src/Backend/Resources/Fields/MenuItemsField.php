<?php

namespace Oscer\Cms\Backend\Resources\Fields;

use Closure;
use Illuminate\Http\Request;
use Oscer\Cms\Core\Menus\Models\Menu;

class MenuItemsField extends Field
{
    public string $component = 'MenuItemsField';

    protected array $with = ['model'];

    public function __construct(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null
    ) {
        $fillResourceCallback = $fillResourceCallback ?: function (Menu $model, Request $request) {
            $updatedItems = json_decode($request->input($this->name), true);
            foreach ($updatedItems as $updatedItem) {
                if ($item = $model->items()->firstWhere('id', $updatedItem['id'])) {
                    $item->update(['order' => $updatedItem['order']]);
                }
            }
        };
        parent::__construct($name, $label, $resolveValueCallback, $fillResourceCallback);
    }
}
