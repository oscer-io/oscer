<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers\Api;

use Bambamboole\LaravelCms\Users\Http\Requests\UpdateProfileAvatarRequest;

class ProfileAvatarController
{
    public function update(UpdateProfileAvatarRequest $request)
    {
        $path = $request->file('avatar')->store('public/avatars');

        auth()->user()->update([
            'avatar' => "/storage/{$path}",
        ]);

        return ['avatar' => "/storage/{$path}"];
    }
}
