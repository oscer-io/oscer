<?php

namespace Bambamboole\LaravelCms\Models;

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
    public static function getValueByKey(string $key): string
    {
        return static::query()->where('key',$key)->firstOrFail()->value;
    }
}
