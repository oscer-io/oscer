<?php

namespace Bambamboole\LaravelCms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validated()
    {
        $data = parent::validated();

        if (isset($data['body'])) {
            $data['body'] = '';
        }

        return $data;
    }

    public function rules(): array
    {
        $uniqueRule = Rule::unique(config('cms.database_connection').'.pages', 'slug')
            ->ignore($this->route('page'));

        return [
            'name' => ['required', 'string'],
            'slug' => [
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                $uniqueRule,
            ],
            'body' => ['string'],
        ];
    }
}
