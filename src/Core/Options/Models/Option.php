<?php

namespace Bambamboole\LaravelCms\Core\Options\Models;

use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string key
 * @property string value
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Option extends BaseModel
{
    public static function getValueByKey(string $key, $default = null): ?string
    {
        $option = static::query()->where('key', $key)->first();

        return $option ? $option->value : $default;
    }
}
