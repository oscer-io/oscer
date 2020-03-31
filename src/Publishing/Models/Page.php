<?php

namespace Bambamboole\LaravelCms\Publishing\Models;

class Page extends Post
{
    protected $with = ['author'];
}
