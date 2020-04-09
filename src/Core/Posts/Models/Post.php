<?php

namespace Bambamboole\LaravelCms\Core\Posts\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Core\Posts\Forms\PostForm;
use Bambamboole\LaravelCms\Core\Posts\Resources\PostResource;
use Illuminate\Http\Request;
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
 * @property \Bambamboole\LaravelCms\Core\Users\Models\User author
 * @property int author_id
 * @property Collection tags
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel implements
    FormResource,
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint,
    HasStoreEndpoint,
    HasUpdateEndpoint,
    HasDeleteEndpoint
{
    use HasSlug;

    protected $table = 'cms_posts';

    protected $with = ['tags', 'author'];

    protected static function booted()
    {
        static::creating(function (self $post) {
            if (!$post->author_id) {
                $post->author_id = auth()->user()->id;
            }
            $post->type = $post->getType();
        });
    }

    public static function create(array $attributes): self
    {
        return tap(parent::query()->newModelInstance($attributes), function ($instance) {
            $instance->type = Str::snake(class_basename($instance));
            $instance->save();
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

    /**
     * @param array $value
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

    public function getForm(): Form
    {
        return new PostForm($this);
    }

    public function executeIndex()
    {
        return $this->asResourceCollection($this->newQuery()->where('type', $this->getType())->paginate());
    }

    public function executeShow($id)
    {
        return $this->findByIdentifier($id)->asApiResource();
    }

    public function executeStore(Request $request)
    {
        $form = $this->getForm();

        $post = $form->save($request);

        return $this->asResource($post);
    }

    public function executeUpdate(Request $request, $identifier)
    {
        $post = $this->findByIdentifier($identifier);
        $form = $post->getForm();

        $updatedPost = $form->save($request);

        return $this->asResource($updatedPost);
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }

    /**
     * We use this method to abstract the resource instantiation.
     * This way we rely on the api implementation of the Post
     * but override the returned resources as we need.
     */
    protected function asResource($model)
    {
        return new PostResource($model);
    }

    /**
     * Same as the method above but with the collection.
     */
    protected function asResourceCollection($models)
    {
        return PostResource::collection($models);
    }

    public function isCreation(): bool
    {
        return $this->id === null;
    }

    public function findByIdentifier(string $identifier): FormResource
    {
        return $this->newQuery()->findOrFail($identifier);
    }

    public function asApiResource()
    {
        return new PostResource($this);
    }
}
