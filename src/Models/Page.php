<?php

namespace Bambamboole\LaravelCms\Models;

use Illuminate\Support\Carbon;
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
 * @property int author_id
 * @property User author
 * @property string name
 * @property string slug
 * @property string body
 * @property Carbon published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Page extends BaseModel
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
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['author'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
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
}
