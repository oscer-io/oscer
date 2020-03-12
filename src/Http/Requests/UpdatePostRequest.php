<?php

namespace Bambamboole\LaravelCms\Http\Requests;

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
        if (is_null($data['body'])) {
            $data['body'] = '';
        }

        if (is_null($data['tags'])) {
            $data['tags'] = [];
        }

        return $data;
    }

    public function rules(): array
    {
        $uniqueRule = Rule::unique(config('cms.database_connection').'.posts', 'slug')
            ->ignore($this->route('post'));

        return [
            'name'   => ['filled', 'string'],
            'slug'   => [
                'filled',
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                $uniqueRule,
            ],
            'tags'   => ['array'],
            'tags.*' => ['string'],
            'body'   => ['string', 'nullable'],
        ];
    }
}
