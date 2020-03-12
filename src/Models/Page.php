<?php

namespace Bambamboole\LaravelCms\Models;

use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int author_id
 * @property string name
 * @property string slug
 * @property string body
 * @property Carbon published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Page extends BaseModel
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'body' => '',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['author'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
