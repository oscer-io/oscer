<?php

namespace Bambamboole\LaravelCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['filled', 'string'],
            'email' => [
                'filled',
                'email',
                Rule::unique('cms_users', 'email')->ignore($this->route('user')),
            ],
            'bio' => ['filled', 'string'],
        ];
    }
}
