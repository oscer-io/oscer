<?php

namespace Bambamboole\LaravelCms\Api\Http\Controllers;

use Bambamboole\LaravelCms\Api\Http\Requests\IssueTokenRequest;
use Bambamboole\LaravelCms\Core\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class IssueTokenController
{
    public function __invoke(IssueTokenRequest $request)
    {
        /** @var \Bambamboole\LaravelCms\Core\Models\User $user */
        $user = User::query()->where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->getAuthPassword())) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.'],
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }

        return response()->json(['token' => $user->createToken('admin_ui')->plainTextToken], 201);
    }
}
