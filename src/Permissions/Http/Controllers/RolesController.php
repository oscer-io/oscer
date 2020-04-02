<?php

namespace Bambamboole\LaravelCms\Permissions\Http\Controllers;

use Bambamboole\LaravelCms\Permissions\Http\Resources\RoleResource;
use Bambamboole\LaravelCms\Permissions\Models\Role;

class RolesController
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function show(int $id)
    {
        return new RoleResource(Role::query()->findOrFail($id));
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
