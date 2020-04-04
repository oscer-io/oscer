<?php

namespace Bambamboole\LaravelCms\Options;

use Bambamboole\LaravelCms\Options\Http\Resources\OptionResource;
use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Frontend\Theming\Contracts\Theme;
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

    protected function getMergedOptionFields(): Collection
    {
        return collect(
            array_merge(
                $this->config->get('cms.options'),
                ['theme' => $this->theme->getOptions()]
            )
        );
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
