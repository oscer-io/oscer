<?php

namespace Bambamboole\LaravelCms\Menus\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'menu' => $this->menu,
            'order' => $this->order,
        ];
    }
}
