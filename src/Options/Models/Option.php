<?php

namespace Bambamboole\LaravelCms\Options\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Options\OptionRepository;
use Bambamboole\LaravelCms\Options\Resources\OptionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @property int id
 * @property string key
 * @property string value
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Option extends BaseModel implements HasApiEndpoints, HasIndexEndpoint, HasStoreEndpoint
{
    public static function getValueByKey(string $key, $default = null): ?string
    {
        $option = static::query()->where('key', $key)->first();

        return $option ? $option->value : null;
    }

    public function executeIndex()
    {
        return ['data' => $this->getRepository()->getOptionFields()];
    }

    protected function getRepository(): OptionRepository
    {
        return app(OptionRepository::class);
    }

    public function executeStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required', 'string'],
            'value' => ['string', 'nullable'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $option = $this->getRepository()->store($request->input('key'), $request->input('value'));

        return new OptionResource($option);
    }
}
