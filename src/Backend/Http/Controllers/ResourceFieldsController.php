<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Publishing\Http\Resources\PostResource;
use Bambamboole\LaravelCms\Publishing\Models\Post;
use Bambamboole\LaravelCms\Users\Http\Resources\ProfileResource;
use Bambamboole\LaravelCms\Core\Http\Resources\UserResource;

class ResourceFieldsController
{
    public function __invoke(string $resource)
    {
        switch ($resource) {
            case 'user':
                return new UserResource(new User());
            case 'profile':
                return new ProfileResource(auth()->user());
            case 'post':
                return new PostResource(new Post());
            default:
                return [];
        }
    }
}
