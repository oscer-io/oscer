<?php

namespace Oscer\Cms\Api\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Oscer\Cms\Api\Http\Requests\IssueTokenRequest;
use Oscer\Cms\Core\Models\User;

class IssueTokenController
{
    public function __invoke(IssueTokenRequest $request)
    {
        /** @var \Oscer\Cms\Core\Models\User $user */
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
