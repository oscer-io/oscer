<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;


class SelectField extends Field
{
    public string $component = 'SelectField';

    public array $options = [];

    protected array $with = ['options'];

    /**
     * Each option must have a 'name', a 'label' and a 'value' like this
     * ['name' => 'foo', 'label' => 'bar', 'value' => 'baz'],
     */
    public function options(array $options)
    {
        $this->options = $this->filterOptions($options);

        return $this;
    }

    /**
     * Filter an array of options to provide consistent data. Therefore
     * remove data that does not provide at least a 'name' and
     * fill 'label' & 'value' with 'name' if they aren't
     * set neither.
     */
    protected function filterOptions(array $options)
    {
        $data = [];
        foreach ($options as $option) {
            if ($name = $option['name'] ?? '') {
                $data[] = [
                    'name' => $name,
                    'label' => $option['label'] ?? $name,
                    'value' => $option['value'] ?? $name
                ];
            }
        }

        return $data;
    }


    public function beforeSave()
    {

    }
}
