<?php

namespace Bambamboole\LaravelCms\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPasswordResetLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:cms_users,email'],
        ];
    }
}
