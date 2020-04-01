<?php

namespace Bambamboole\LaravelCms\Permissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
