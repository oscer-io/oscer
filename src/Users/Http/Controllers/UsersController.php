<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers;

use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Users\Http\Requests\UpdateUserRequest;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;

class UsersController
{
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }
}
