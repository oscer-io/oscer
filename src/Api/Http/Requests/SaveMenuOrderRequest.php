<?php

namespace Oscer\Cms\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMenuOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'numeric'],
            'order.*.order' => ['required', 'numeric'],
        ];
    }
}
