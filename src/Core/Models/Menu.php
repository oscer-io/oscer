<?php

namespace Oscer\Cms\Core\Models;

use Oscer\Cms\Core\Models\MenuItem;
use Oscer\Cms\Core\Models\BaseModel;

class Menu extends BaseModel
{
    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order');
    }
}
