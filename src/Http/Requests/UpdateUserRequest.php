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
        $uniqueRule = Rule::unique(config('cms.database_connection').'.users', 'email')
            ->ignore($this->route('user'));

        return [
            'name' => ['nullable|string'],
            'email' => ['nullable|email', $uniqueRule],
            'bio' => ['nullable|string'],
        ];
    }
}
