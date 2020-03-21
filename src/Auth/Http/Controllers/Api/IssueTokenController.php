<?php

namespace Bambamboole\LaravelCms\Auth\Http\Controllers\Api;

use Bambamboole\LaravelCms\Auth\Http\Requests\IssueTokenRequest;
use Bambamboole\LaravelCms\Auth\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class IssueTokenController
{
    public function __invoke(IssueTokenRequest $request)
    {
        /** @var User $user */
        $user = User::query()->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->getAuthPassword())) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.'],
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }

        return $user->createToken('admin_ui')->plainTextToken;
    }
}
