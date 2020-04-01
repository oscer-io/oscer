<?php

namespace Bambamboole\LaravelCms\Permissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:cms_users,email'],
            'bio' => ['filled', 'string'],
        ];
    }
}
