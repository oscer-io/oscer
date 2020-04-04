<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Requests;

use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends BaseRequest
{
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

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => [
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                Rule::unique('cms_posts', 'slug')->ignore($this->route('page')),
            ],
            'body' => ['string'],
        ];
    }
}
