<?php

namespace Bambamboole\LaravelCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'tags' => ['required', 'array'],
            'tags.*' => ['string'],
        ];
    }
}
