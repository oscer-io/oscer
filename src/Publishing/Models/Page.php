<?php

namespace Bambamboole\LaravelCms\Publishing\Models;

use Bambamboole\LaravelCms\Publishing\Forms\PageForm;
use Bambamboole\LaravelCms\Publishing\Resources\PageResource;
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
