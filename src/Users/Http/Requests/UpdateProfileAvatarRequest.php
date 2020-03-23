<?php


namespace Bambamboole\LaravelCms\Users\Http\Requests;


use Bambamboole\LaravelCms\Core\Http\Requests\BaseRequest;

class UpdateProfileAvatarRequest extends BaseRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
          'avatar' => 'required'
        ];
    }
}
