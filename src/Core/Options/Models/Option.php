<?php

namespace Bambamboole\LaravelCms\Core\Options\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Core\Options\Repositories\OptionRepository;
use Bambamboole\LaravelCms\Core\Options\Resources\OptionResource;
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
class Option extends BaseModel implements SavableModel
{
    public static function getValueByKey(string $key, $default = null): ?string
    {
        $option = static::query()->where('key', $key)->first();

        return $option ? $option->value : $default;
    }

    protected function getRepository(): OptionRepository
    {
        return app(OptionRepository::class);
    }

    public function index()
    {
        $fields = $this->getRepository()->getMergedOptionFields();

        if ($fields->count() !== $this->newQuery()->count()) {
            return $fields->map(function (array $field) {
                return $this->newQuery()->firstOrNew(['path' => $field['path']],['path' => $field['path']]);
            });
        } else{
            return $this->newQuery()->get();
        }
    }

    public function show(string $identifier)
    {
        return $this->newQuery()->where('path', $identifier)->firstOrFail();
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }
}
