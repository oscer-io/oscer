<?php

namespace Bambamboole\LaravelCms\Core\Options\Models;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Support\Carbon;

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

    public function index()
    {
        $mergedFields = collect([]);
        collect(array_merge(
            config('cms.options'),
            ['theme' => app(Theme::class)->getOptions(),
            ]
        ))->each(function ($fields, $tab) use ($mergedFields) {
            foreach ($fields as $name => $definition) {
                $mergedFields->add(array_merge(
                    [
                        'name' => $name,
                        'path' => "{$tab}.{$name}",
                    ],
                    $definition
                ));
            }
        });

        if ($mergedFields->count() !== $this->newQuery()->count()) {
            return $mergedFields->map(function (array $field) {
                return $this->newQuery()->firstOrNew(['path' => $field['path']], ['path' => $field['path']]);
            });
        } else {
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
