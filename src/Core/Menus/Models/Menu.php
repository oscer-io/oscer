<?php

namespace Bambamboole\LaravelCms\Core\Menus\Models;

use Bambamboole\LaravelCms\Core\Models\BaseModel;

class Menu extends BaseModel
{
    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order');
    }
}
