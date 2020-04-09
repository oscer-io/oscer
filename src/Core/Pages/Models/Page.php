<?php

namespace Bambamboole\LaravelCms\Core\Pages\Models;

use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Pages\Forms\PageForm;
use Bambamboole\LaravelCms\Core\Pages\Resources\PageResource;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;

class Page extends Post
{
    protected $with = ['author'];

    public function getForm(): Form
    {
        return new PageForm($this);
    }

    public function asApiResource()
    {
        return new PageResource($this);
    }

    protected function asResourceCollection($models)
    {
        return PageResource::collection($models);
    }

    public function getType()
    {
        return 'page';
    }
}
