<?php

namespace Bambamboole\LaravelCms\Publishing\Http\Requests;

use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;

class CreatePageRequest extends BaseRequest
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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => [
                'string',
                'regex:/^[a-zA-Z0-9-]+$/', // like alpha_num but with dashes
                'unique:cms_pages,slug',
            ],
            'body' => ['string'],
        ];
    }
}
