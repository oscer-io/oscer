<?php

namespace Bambamboole\LaravelCms\Core\Pages\Models;

use Bambamboole\LaravelCms\Core\Pages\Forms\PageForm;
use Bambamboole\LaravelCms\Core\Pages\Resources\PageResource;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Page extends Post
{
    protected $with = ['author'];

    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', '=', Str::snake(class_basename(self::class)));
        });
    }

    public function getForm()
    {
        return new PageForm($this);
    }

    protected function asResource($model)
    {
        return new PageResource($model);
    }

    protected function asResourceCollection($models)
    {
        return PageResource::collection($models);
    }
}
