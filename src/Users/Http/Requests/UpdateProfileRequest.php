<?php

namespace Bambamboole\LaravelCms\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('cms_users', 'email')->ignore(auth()->user()->id),
            ],
            'bio' => ['required', 'string'],
            'password' => ['filled', 'confirmed'],
        ];
    }
}
