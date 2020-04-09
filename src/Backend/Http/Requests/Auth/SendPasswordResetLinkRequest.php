<?php

namespace Bambamboole\LaravelCms\Backend\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendPasswordResetLinkRequest extends FormRequest
{
    public function authorize()
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
