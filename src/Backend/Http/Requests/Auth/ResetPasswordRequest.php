<?php

namespace Oscer\Cms\Backend\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'encrypted_token' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
