<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Users\Http\Resources\ProfileResource;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;

class ResourceFieldsController
{
    public function __invoke(string $resource)
    {
        switch ($resource) {
            case 'user':
                return new UserResource(new User());
            case 'profile':
                return new ProfileResource(auth()->user());
            default:
                return [];
        }
    }
}
