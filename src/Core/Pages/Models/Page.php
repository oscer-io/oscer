<?php

namespace Oscer\Cms\Core\Pages\Models;

use Oscer\Cms\Core\Posts\Models\Post;

class Page extends Post
{
    protected $with = ['author'];

    public function getType()
    {
        return 'page';
    }
}
