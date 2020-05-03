<?php

namespace Oscer\Cms\Core\Models;

class Page extends Post
{
    protected $with = ['author'];

    public function getType()
    {
        return 'page';
    }
}
