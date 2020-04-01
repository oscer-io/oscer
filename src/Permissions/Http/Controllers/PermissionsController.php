<?php

namespace Bambamboole\LaravelCms\Permissions\Http\Controllers;

use Bambamboole\LaravelCms\Auth\Mails\NewUserCreatedMail;
use Bambamboole\LaravelCms\Permissions\Http\Resources\PermissionResource;
use Bambamboole\LaravelCms\Permissions\Models\Permission;
use Bambamboole\LaravelCms\Permissions\Models\Role;
use Bambamboole\LaravelCms\Permissions\Http\Requests\CreateRoleRequest;
use Bambamboole\LaravelCms\Permissions\Http\Requests\UpdateRoleRequest;
use Bambamboole\LaravelCms\Permissions\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PermissionsController
{
    public function index()
    {
        return PermissionResource::collection(Permission::all()->sortBy('group')->sortBy('crud'));
    }
//
//    public function show(Role $role)
//    {
//        return new RoleResource($role);
//    }
//
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
