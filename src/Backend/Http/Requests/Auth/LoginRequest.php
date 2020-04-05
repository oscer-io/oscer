<?php

namespace Bambamboole\LaravelCms\Backend\Http\Requests\Auth;

use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
