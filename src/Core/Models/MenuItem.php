<?php

namespace Oscer\Cms\Core\Models;

use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property Menu menu
 * @property int order
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class MenuItem extends BaseModel
{
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
