<?php

namespace Oscer\Cms\Core\Models;

use Oscer\Cms\Core\Models\Post;

class Page extends Post
{
    protected $with = ['author'];

    public function getType()
    {
        return 'page';
    }
}
