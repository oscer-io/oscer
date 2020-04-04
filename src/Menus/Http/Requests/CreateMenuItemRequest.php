<?php

namespace Bambamboole\LaravelCms\Menus\Http\Requests;

use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'menu' => [Rule::in(collect(app(Theme::class)->getMenus())->keys())],
            'name' => ['required', 'string'],
            'url' => ['required', 'string'],
        ];
    }
}
