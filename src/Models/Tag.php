<?php

namespace Bambamboole\LaravelCms\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property string description
 * @property Collection posts
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Tag extends BaseModel
{
    use HasSlug;

    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
