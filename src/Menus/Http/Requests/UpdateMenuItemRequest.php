<?php

namespace Bambamboole\LaravelCms\Menus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['filled', 'string'],
            'url' => ['filled', 'string'],
        ];
    }
}
