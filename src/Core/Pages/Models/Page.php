<?php

namespace Bambamboole\LaravelCms\Core\Pages\Models;

use Bambamboole\LaravelCms\Core\Posts\Models\Post;

class Page extends Post
{
    protected $with = ['author'];

    public function getType()
    {
        return 'page';
    }
}
