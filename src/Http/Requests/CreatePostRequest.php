<?php

namespace Bambamboole\LaravelCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function validated()
    {
        $data = parent::validated();

        if (! isset($data['body'])) {
            $data['body'] = '';
        }

        return $data;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $uniqueRule = Rule::unique(config('cms.database_connection').'.posts', 'slug');

        return [
            'name' => ['required', 'string'],
            'slug' => [
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                $uniqueRule,
            ],
            'tags' => ['array'],
            'tags.*' => ['string'],
            'body' => ['string'],
        ];
    }
}
