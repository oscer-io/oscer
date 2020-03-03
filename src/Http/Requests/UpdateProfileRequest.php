<?php

namespace Bambamboole\LaravelCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uniqueRule = Rule::unique(config('cms.database_connection') . '.users', 'email')
            ->ignore(auth()->user()->id);

        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', $uniqueRule],
            'bio' => ['required', 'string'],
        ];
    }

}
