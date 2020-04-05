<?php

namespace Bambamboole\LaravelCms\Publishing\Models;

use Bambamboole\LaravelCms\Publishing\Forms\PageForm;
use Bambamboole\LaravelCms\Publishing\Resources\PageResource;

class Page extends Post
{
    protected $with = ['author'];

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
