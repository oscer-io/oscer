<?php

namespace Bambamboole\LaravelCms\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int id
 * @property string title
 * @property string slug
 * @property string body
 * @property User author
 * @property Collection tags
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel
{
    use HasSlug;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'body' => '',
    ];

    protected $with = ['tags', 'author'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @param array $value
     */
    public function setTagsAttribute(array $value)
    {
        $tags = collect($value)
            ->map(function (string $name) {
                return Tag::query()->firstOrCreate(['name' => $name]);
            })
            ->pluck('id');

        $this->tags()->sync($tags);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
