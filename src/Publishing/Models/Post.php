<?php

namespace Bambamboole\LaravelCms\Publishing\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Publishing\Forms\PostForm;
use Bambamboole\LaravelCms\Publishing\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
 * @property \Bambamboole\LaravelCms\Core\Models\User author
 * @property int author_id
 * @property Collection tags
 * @property Carbon|null published_at
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class Post extends BaseModel implements
    HasForm,
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
        return $this->belongsTo(\Bambamboole\LaravelCms\Core\Models\User::class);
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

    public function getForm()
    {
        return new PostForm($this);
    }

    public function executeIndex()
    {
        return $this->asResourceCollection($this->newQuery()->paginate());
    }

    public function executeShow($id)
    {
        return $this->asResource($this->newQuery()->findOrFail($id));
    }

    public function executeStore(Request $request)
    {
        $form = $this->getForm();
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model = $form->save();

        return $this->asResource($model);
    }

    public function executeUpdate(Request $request, $identifier)
    {
        $model = $this->newQuery()->findOrFail($identifier);
        $form = $model->getForm();
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $updatedModel = $form->save();

        return $this->asResource($updatedModel);
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }

    protected function asResource($model)
    {
        return new PostResource($model);
    }

    protected function asResourceCollection($models)
    {
        return PostResource::collection($models);
    }
}
