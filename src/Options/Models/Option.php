<?php

namespace Bambamboole\LaravelCms\Options\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Options\OptionRepository;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string key
 * @property string value
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Option extends BaseModel implements HasApiEndpoints, HasIndexEndpoint
{
    public static function getValueByKey(string $key, $default = null): ?string
    {
        $option = static::query()->where('key', $key)->first();

        return $option ? $option->value : null;
    }

    public function getEndpoints(): array
    {
        return ['index'];
    }

    public function executeIndex()
    {
        return ['data' => $this->getRepository()->getOptionFields()];
    }

    protected function getRepository(): OptionRepository
    {
        return app(OptionRepository::class);
    }
}
