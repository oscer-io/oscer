<?php

namespace Bambamboole\LaravelCms\Backend\Http\Requests\Auth;

use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;

class SendPasswordResetLinkRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:cms_users,email'],
        ];
    }
}
