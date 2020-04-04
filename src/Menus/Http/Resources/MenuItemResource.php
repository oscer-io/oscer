<?php

namespace Bambamboole\LaravelCms\Menus\Http\Resources;

use Bambamboole\LaravelCms\Backend\Http\Resources\BackendResource;

class MenuItemResource extends BackendResource
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
