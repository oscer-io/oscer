<?php

namespace Oscer\Cms\Core\Models;

class Menu extends BaseModel
{
    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order');
    }
}
