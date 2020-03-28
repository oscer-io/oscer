<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers;

use Bambamboole\LaravelCms\Users\Http\Requests\UpdateProfileRequest;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;

class ProfileController
{
    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());

        return new UserResource(auth()->user());
    }
}
