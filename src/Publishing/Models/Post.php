<?php

namespace Bambamboole\LaravelCms\Publishing\Models;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
 * @property User author
 * @property int author_id
 * @property Collection tags
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel
{
    use HasSlug;

    protected $table = 'cms_posts';

    protected $with = ['tags', 'author'];

    public static function create(array $attributes): self
    {
        return tap(parent::query()->newModelInstance($attributes), function ($instance) {
            $instance->type = Str::snake(class_basename($instance));
            $instance->save();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

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

        if ($this->id !== null) {
            $this->tags()->sync($tags);
        } else {
            self::created(function (Post $post) use ($tags) {
                $post->tags()->sync($tags);
            });
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
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
