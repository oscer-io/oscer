<?php

namespace Bambamboole\LaravelCms\Api\Http\Requests;

use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;

class IssueTokenRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
