<?php

namespace Bambamboole\LaravelCms\Models;

use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property string slug
 * @property string body
 * @property User author
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel
{
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
