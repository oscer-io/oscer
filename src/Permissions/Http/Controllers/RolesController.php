<?php

namespace Bambamboole\LaravelCms\Permissions\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Mails\NewUserCreatedMail;
use Bambamboole\LaravelCms\Permissions\Http\Requests\CreateRoleRequest;
use Bambamboole\LaravelCms\Permissions\Http\Requests\UpdateRoleRequest;
use Bambamboole\LaravelCms\Permissions\Http\Resources\RoleResource;
use Bambamboole\LaravelCms\Permissions\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RolesController
{
    public function index()
    {
        return RoleResource::collection(Role::query()->paginate());
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

//    public function update(UpdateRoleRequest $request, Role $role)
//    {
//        $role->update($request->validated());
//
//        return new RoleResource($role);
//    }
//
//    public function store(CreateRoleRequest $request)
//    {
//        $role = Role::query()->create(array_merge([
//            'password' => $password = Str::random(), ],
//            $request->validated()
//        ));
//
//        Mail::to($role->email)->send(new NewUserCreatedMail($password));
//
//        return new RoleResource($role);
//    }
//
//    public function delete(Role $role)
//    {
//        $role->delete();
//
//        return ['success' => true];
//    }
}
