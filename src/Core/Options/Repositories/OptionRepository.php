<?php

namespace Bambamboole\LaravelCms\Core\Options\Repositories;

use Bambamboole\LaravelCms\Core\Options\Models\Option;
use Bambamboole\LaravelCms\Core\Options\Resources\OptionResource;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;

class OptionRepository
{
    protected Repository $config;

    protected Theme $theme;

    protected $options = null;

    public function __construct(Repository $config, Theme $theme)
    {
        $this->config = $config;
        $this->theme = $theme;
    }

    public function getOptionFields(): Collection
    {
        return $this
            ->getMergedOptionFields()
            ->map(function ($fields, $tab) {
                return $this->mergeValuesIntoOptionFields($tab, $fields);
            });
    }

    public function getMergedOptionFields(): Collection
    {
        $mergedFields = collect([]);

        collect(array_merge(
            $this->config->get('cms.options'),
            ['theme' => $this->theme->getOptions()]
        ))->each(function ($fields, $tab) use ($mergedFields) {
            foreach ($fields as $name => $definition) {
                $data = array_merge([
                    'name' => $name,
                    'path' => "{$tab}.{$name}",
                ], $definition);
            }
            $mergedFields->add($data);
        });

        return $mergedFields;
    }

    protected function mergeValuesIntoOptionFields(string $tab, array $fields): Collection
    {
        $fields = collect($fields)
            ->map(function ($info, $name) use ($tab) {
                $info['key'] = "{$tab}.{$name}";
                $info['value'] = $this->getOptionValue($info['key']);

                return $info;
            });

        return $fields;
    }

    protected function getOptionValue($key): ?string
    {
        $option = $this->getOptions()->first(function ($option) use ($key) {
            return $option['key'] === $key;
        });

        return $option ? $option->value : null;
    }

    protected function getOptions(): Collection
    {
        if (! $this->options) {
            $this->options = Option::all()->map(function (Option $option) {
                return new OptionResource($option);
            });
        }

        return $this->options;
    }

    public function store(string $key, ?string $value)
    {
        return Option::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
