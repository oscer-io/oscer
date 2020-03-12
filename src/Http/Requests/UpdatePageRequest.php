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

        if (is_null($data['body'])) {
            $data['body'] = '';
        }

        return $data;
    }

    public function rules(): array
    {
        $uniqueRule = Rule::unique(config('cms.database_connection').'.pages', 'slug')
            ->ignore($this->route('page'));

        return [
            'name' => ['filled', 'string'],
            'slug' => [
                'filled',
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                $uniqueRule,
            ],
            'body' => ['filled', 'string'],
        ];
    }
}
