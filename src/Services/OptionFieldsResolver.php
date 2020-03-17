<?php

namespace Bambamboole\LaravelCms\Services;

use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\Config\Repository;

class OptionFieldsResolver
{
    protected Repository $config;

    protected Theme $theme;

    protected $options = null;

    public function __construct(Repository $config, Theme $theme)
    {
        $this->config = $config;
        $this->theme = $theme;

    }

    public function getOptionFields()
    {
        return $this
            ->getMergedOptionFields()
            ->map(function ($fields, $tab) {
                return $this->mergeValuesIntoOptionFields($tab, $fields);
            });
    }

    protected function getMergedOptionFields()
    {
        return collect(
            array_merge(
                $this->config->get('cms.options'),
                ['theme' => $this->theme->getOptions()]
            )
        );
    }

    protected function mergeValuesIntoOptionFields(string $tab, array $fields)
    {
        $fields = collect($fields)
            ->map(function ($info, $name) use ($tab) {
                $info['value'] = $this->getOptionValue("{$tab}/{$name}");
                return $info;
            });

        return $fields;
    }

    protected function getOptionValue($key)
    {
        $option = $this->getOptions()->first(function ($option) use ($key) {
            return $option['key'] === $key;
        });

        return $option ? $option->value : null;
    }

    protected function getOptions()
    {
        if (!$this->options) {
            $this->options = Option::all();
        }

        return $this->options;
    }
}
