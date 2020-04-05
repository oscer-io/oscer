<?php

namespace Bambamboole\LaravelCms\Core\Posts\Models;

use Bambamboole\LaravelCms\Core\Models\BaseModel;
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

    /**
     * Update the updated_at of the relationships.
     *
     * @var array
     */
    protected $touches = ['posts'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)->where('type', 'post');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
