<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Models\User;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;

class CreationFieldsController
{
    public function __invoke(string $resource)
    {
        switch ($resource) {
            case 'user':
                return new UserResource(new User());
            default:
                return [];
        }
    }
}
