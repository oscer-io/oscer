<?php

namespace Bambamboole\LaravelCms\Menus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'url' => ['required', 'string'],
        ];
    }
}
