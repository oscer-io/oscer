<?php

namespace Bambamboole\LaravelCms\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    protected $guarded = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? 'cms_'.Str::snake(Str::pluralStudly(class_basename($this)));
    }

    /**
     * Get the joining table name for a many-to-many relation.
     *
     * @param  string  $related
     * @param  \Illuminate\Database\Eloquent\Model|null  $instance
     * @return string
     */
    public function joiningTable($related, $instance = null)
    {
        return 'cms_'.parent::joiningTable($related, $instance);
    }
}
