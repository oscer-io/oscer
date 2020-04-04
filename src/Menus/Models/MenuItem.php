<?php

namespace Bambamboole\LaravelCms\Menus\Models;

use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Menus\Forms\MenuItemForm;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property string menu
 * @property int order
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class MenuItem extends BaseModel
{
    public function getForm()
    {
        return new MenuItemForm($this);
    }
}
