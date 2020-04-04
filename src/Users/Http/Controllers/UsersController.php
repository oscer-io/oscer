<?php

namespace Bambamboole\LaravelCms\Users\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Mails\NewUserCreatedMail;
use Bambamboole\LaravelCms\Core\Models\User;
use Bambamboole\LaravelCms\Users\Http\Requests\CreateUserRequest;
use Bambamboole\LaravelCms\Users\Http\Requests\UpdateUserRequest;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController
{
    public function index()
    {
        return UserResource::collection(User::query()->paginate());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::query()->create(array_merge([
            'password' => $password = Str::random(), ],
            $request->validated()
        ));

        Mail::to($user->email)->send(new NewUserCreatedMail($password));

        return new UserResource($user);
    }

    public function delete(User $user)
    {
        $user->delete();

        return ['success' => true];
    }
}
