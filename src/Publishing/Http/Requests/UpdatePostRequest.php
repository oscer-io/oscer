<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validated()
    {
        $data = parent::validated();

        if (! isset($data['body'])) {
            $data['body'] = '';
        }

        return $data;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'string'],
            'slug'   => [
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                Rule::unique('cms_posts', 'slug')->ignore($this->route('post')),
            ],
            'tags'   => ['array'],
            'tags.*' => ['string'],
            'body'   => ['string'],
        ];
    }
}
