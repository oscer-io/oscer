<?php

namespace Bambamboole\LaravelCms\Core\Posts\Models;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Backend\Resources\IsSavableEloquentModel;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int id
 * @property string name
 * @property string slug
 * @property string body
 * @property \Bambamboole\LaravelCms\Core\Users\Models\User author
 * @property int author_id
 * @property Collection tags
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel implements SavableModel
{
    use HasSlug;
    use IsSavableEloquentModel;

    protected $table = 'cms_posts';

    protected $with = ['tags', 'author'];

    protected static function booted()
    {
        static::creating(function (self $post) {
            if (! $post->author_id) {
                $post->author_id = auth()->user()->id;
            }
            $post->type = $post->getType();
        });
    }

    public function getType()
    {
        return 'post';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Bambamboole\LaravelCms\Core\Users\Models\User::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * This method allows to set the tags on a post via the property.
     * If it is a new model they will be synced in a event callback.
     */
    public function setTagsAttribute(array $value)
    {
        /*
         * First we retrieve or create all used tags and pluck the id's
         */
        $tags = collect($value)
            ->map(function (string $name) {
                return Tag::query()->firstOrCreate(['name' => $name]);
            })
            ->pluck('id');

        /*
         * If the post exists we can simply sync the tags with the post. But if
         * we do not have the required id for the pivot table, we register a
         * `created` callback which syncs the tags with the post.
         */
        if ($this->id !== null) {
            $this->tags()->sync($tags);
        } else {
            self::created(function (self $post) use ($tags) {
                $post->tags()->sync($tags);
            });
        }
    }

    public function getRenderedBody()
    {
        $languages = ['php', 'bash', 'yaml', 'ini', 'dockerfile'];
        $env = Environment::createCommonMarkEnvironment();
        $env->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($languages));
        $env->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($languages));
        $converter = new CommonMarkConverter([], $env);

        return $converter->convertToHtml($this->body);
    }

    public function joiningTableSegment()
    {
        return 'post';
    }
}
